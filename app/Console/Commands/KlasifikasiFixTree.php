<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Klasifikasi;

class KlasifikasiFixTree extends Command
{
    protected $signature = 'klasifikasi:fix-tree';
    protected $description = 'Auto generate parent & susun tree klasifikasi';

    public function handle()
    {
        $this->info('Generate parent otomatis...');

        $allKode = Klasifikasi::pluck('kode')->toArray();

        foreach ($allKode as $kode) {

            $parts = explode('.', $kode);
            $parentKode = '';

            for ($i = 0; $i < count($parts) - 1; $i++) {

                $parentKode = $parentKode
                    ? $parentKode . '.' . $parts[$i]
                    : $parts[$i];

                Klasifikasi::firstOrCreate(
                    ['kode' => $parentKode],
                    ['nama' => 'AUTO GENERATED']
                );
            }
        }

        $this->info('Set parent_id...');

        $all = Klasifikasi::orderBy('kode')->get();

        foreach ($all as $item) {

            if (!str_contains($item->kode, '.')) {
                $item->parent_id = null;
                $item->save();
                continue;
            }

            $parentKode = substr($item->kode, 0, strrpos($item->kode, '.'));

            $parent = Klasifikasi::where('kode', $parentKode)->first();

            if ($parent) {
                $item->parent_id = $parent->id;
                $item->save();
            }
        }

        $this->info('TREE BERHASIL ✅');
    }
}