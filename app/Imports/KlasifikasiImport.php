<?php

namespace App\Imports;

use App\Models\Klasifikasi;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class KlasifikasiImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows->skip(1) as $row) {

            $kode = trim($row[0]);
            $nama = trim($row[1]);
            $parentKode = $row[2] ?? null;

            if(!$kode || !$nama) continue;

            // hapus teks sampah PDF
            $nama = preg_replace('/Dokumen ini.*/','',$nama);

            $parent_id = null;

            if($parentKode){

                $parent = Klasifikasi::where('kode',$parentKode)->first();

                if($parent){
                    $parent_id = $parent->id;
                }

            }

            // hindari duplikat
            if(!Klasifikasi::where('kode',$kode)->exists()){

                Klasifikasi::create([
                    'kode'=>$kode,
                    'nama'=>$nama,
                    'parent_id'=>$parent_id
                ]);

            }

        }
    }
}
