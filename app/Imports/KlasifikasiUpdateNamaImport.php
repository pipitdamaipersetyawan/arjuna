<?php

namespace App\Imports;

use App\Models\Klasifikasi;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class KlasifikasiUpdateNamaImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {

            // skip header
            if ($index == 0) {
                continue;
            }

            $kode = trim($row[0] ?? '');
            $nama = trim($row[1] ?? '');

            if (!$kode || !$nama) {
                continue;
            }

            $data = Klasifikasi::where('kode', $kode)->first();

            if ($data) {
                $data->update([
                    'nama' => $nama
                ]);
            }
        }
    }
}
