<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class SuratMasukExport implements FromCollection
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

'No'=>$i+1,

'Tanggal Input'=>$row->tanggal,

'Pengirim'=>$row->surat_dari,

'No Surat'=>$row->nomor_surat,

'Isi Informasi'=>$row->isi_informasi,

'Klasifikasi'=>$row->klasifikasi_kode,

'Keterangan'=>$row->keterangan ?? '-'

];

});

}

}
