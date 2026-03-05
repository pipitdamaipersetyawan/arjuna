<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Naskah extends Model
{
    protected $fillable = [
        'tanggal_surat',
        'pengirim',
        'jenis_naskah',
        'sifat_naskah',
        'kode_sifat',
        'klasifikasi_kode',
        'nomor_naskah',
        'no_urut',
        'hal',
        'ringkasan',
        'file',
        'tujuan_manual'
    ];

    // ✅ TAMBAHKAN INI (RELASI KE TUJUAN)
    public function tujuan()
    {
          return $this->belongsToMany(
        \App\Models\Tujuan::class,
        'naskah_tujuan',
        'naskah_id',
        'tujuan_id'
          );
}
}
