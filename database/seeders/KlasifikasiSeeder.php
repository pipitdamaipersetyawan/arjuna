<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Klasifikasi;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class KlasifikasiSeeder extends Seeder
{
    public function run(): void
    {

        // kosongkan tabel dulu
        DB::table('klasifikasis')->truncate();

        // ROOT KLASIFIKASI ANRI
        $root = [

            ['kode'=>'000','nama'=>'UMUM'],
            ['kode'=>'100','nama'=>'PEMERINTAHAN'],
            ['kode'=>'200','nama'=>'POLITIK'],
            ['kode'=>'300','nama'=>'KEAMANAN DAN KETERTIBAN'],
            ['kode'=>'400','nama'=>'KESEJAHTERAAN RAKYAT'],
            ['kode'=>'500','nama'=>'PEREKONOMIAN'],
            ['kode'=>'600','nama'=>'PEKERJAAN UMUM DAN KETENAGAAN'],
            ['kode'=>'700','nama'=>'PENGAWASAN'],
            ['kode'=>'800','nama'=>'KEPEGAWAIAN'],
            ['kode'=>'900','nama'=>'KEUANGAN'],

        ];

        foreach($root as $item){

            Klasifikasi::create([
                'kode'=>$item['kode'],
                'nama'=>$item['nama'],
                'parent_id'=>null
            ]);

        }

        // =============================
        // IMPORT EXCEL KLASIFIKASI ANRI
        // =============================

        $rows = Excel::toArray([], public_path('klasifikasi_arsip_perwal41_full_laravel.xlsx'))[0];

        foreach($rows as $i=>$row){

            if($i==0) continue;

            $kode = trim($row[0]);
            $nama = trim($row[1]);
            $parentKode = $row[2] ?? null;

            if(!$kode || !$nama) continue;

            $parent_id = null;

            if($parentKode){

                $parent = Klasifikasi::where('kode',$parentKode)->first();

                if($parent){
                    $parent_id = $parent->id;
                }

            }

            // hindari duplikasi
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
