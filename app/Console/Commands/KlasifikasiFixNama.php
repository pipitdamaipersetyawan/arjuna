<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Klasifikasi;

class KlasifikasiFixNama extends Command
{
    protected $signature = 'klasifikasi:fix-nama';
    protected $description = 'Mengisi nama parent dari turunan';

    public function handle()
    {
        $this->info('Memperbaiki nama parent...');

        $parents = Klasifikasi::where('nama', 'AUTO GENERATED')->get();

        foreach ($parents as $parent) {

            // cari semua child
            $child = Klasifikasi::where('parent_id', $parent->id)
                        ->orderBy('kode')
                        ->first();

            if ($child) {
                $parent->nama = $child->nama;
                $parent->save();
            }

        }

        $this->info('Nama parent berhasil diperbaiki ✅');
    }
}