<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SuratMasukExport implements FromCollection, WithHeadings
{

protected $data;

public function __construct($data)
{
    $this->data = $data;
}

public function collection()
{

return collect($this->data)->map(function($row,$i){

return [

$i+1,

$row->tanggal ?? '',

$row->surat_dari ?? '',

$row->nomor_surat ?? '',

$row->isi_informasi ?? '',

$row->klasifikasi_kode ?? '',

$row->keterangan ?? '-'

];

});

}

public function headings(): array
{
return [

'No',

'Tanggal Input',

'Pengirim',

'No Surat',

'Isi Informasi',

'Klasifikasi',

'Keterangan'

];
}

}
