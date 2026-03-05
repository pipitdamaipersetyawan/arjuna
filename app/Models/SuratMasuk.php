<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    protected $table = 'surat_masuks';

    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */
    protected $fillable = [
    'tanggal',
    'klasifikasi_kode', // 🔥 wajib ada
    'surat_dari',
    'tanggal_surat',
    'nomor_surat',
    'isi_informasi',
    'no_agenda',
    'keterangan',
    'file'
];

    /*
    |--------------------------------------------------------------------------
    | CASTING DATA TYPE
    |--------------------------------------------------------------------------
    */
    protected $casts = [
        'tanggal'       => 'date',
        'tanggal_surat' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | ACCESSOR FORMAT TANGGAL (UNTUK TAMPILAN)
    |--------------------------------------------------------------------------
    */
    public function getTanggalFormattedAttribute()
    {
        return $this->tanggal
            ? $this->tanggal->format('d-m-Y')
            : null;
    }

    public function getTanggalSuratFormattedAttribute()
    {
        return $this->tanggal_surat
            ? $this->tanggal_surat->format('d-m-Y')
            : null;
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSOR FILE URL
    |--------------------------------------------------------------------------
    */
    public function getFileUrlAttribute()
    {
        return $this->file
            ? asset('storage/' . $this->file)
            : null;
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPE FILTER PENCARIAN (UNTUK RIWAYAT)
    |--------------------------------------------------------------------------
    */
    public function scopeFilter($query, $request)
    {
        if ($request->cari) {
            $query->where('surat_dari', 'like', '%' . $request->cari . '%')
                  ->orWhere('nomor_surat', 'like', '%' . $request->cari . '%');
        }
    }
}
