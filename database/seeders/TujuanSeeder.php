<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tujuan;

class TujuanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [

            'Inspektur Kota Semarang',
            'Kepala Bappeda Kota Semarang',
            'Kepala BRIDA Kota Semarang',
            'Kepala BKPP Kota Semarang',
            'Kepala BPKAD Kota Semarang',
            'Kepala Bapenda Kota Semarang',
            'Kepala Badan Kesatuan Bangsa dan Politik Kota Semarang',
            'Kepala BPBD Kota Semarang',
            'Kepala Satpol PP Kota Semarang',
            'Direktur RSD KRMT Wongsonegoro Kota Semarang',
            'Sekretaris DPRD Kota Semarang',
            'Kepala Dinas Pendidikan Kota Semarang',
            'Kepala Dinas Kesehatan Kota Semarang',
            'Kepala Dinas Pekerjaan Umum Kota Semarang',
            'Kepala Dinas Penataan Ruang Kota Semarang',
            'Kepala Dinas Perumahan dan Kawasan Permukiman Kota Semarang',
            'Kepala Dinas Ketahanan Pangan Kota Semarang',
            'Kepala Dinas Lingkungan Hidup Kota Semarang',
            'Kepala Dinas Kependudukan dan Pencatatan Sipil Kota Semarang',
            'Kepala Dinas Pengendalian Penduduk dan KB Kota Semarang',
            'Kepala Dinas Perhubungan Kota Semarang',
            'Kepala Dinas Arsip dan Perpustakaan Kota Semarang',
            'Kepala Dinas Perikanan Kota Semarang',
            'Kepala Dinas Pertanian Kota Semarang',
            'Kepala Dinas Perdagangan Kota Semarang',
            'Kepala Dinas Perindustrian Kota Semarang',
            'Kepala Dinas Koperasi dan Usaha Mikro Kota Semarang',
            'Kepala Dinas Penanaman Modal dan PTSP Kota Semarang',
            'Kepala Dinas Kepemudaan dan Olah Raga Kota Semarang',
            'Kepala Dinas Kebudayaan dan Pariwisata Kota Semarang',
            'Kepala Dinas Pemadam Kebakaran Kota Semarang',
            'Kepala Dinas Sosial Kota Semarang',
            'Kepala Dinas Tenaga Kerja Kota Semarang',
            'Kepala Dinas Pemberdayaan Perempuan dan Perlindungan Anak Kota Semarang',
            'Kepala Dinas Komunikasi, Informatika, Statistik, dan Persandian Kota Semarang',
            'Kepala Bagian Tata Pemerintahan Setda Kota Semarang',
            'Kepala Bagian Kerjasama dan Otda Setda Kota Semarang',
            'Kepala Bagian Hukum Setda Kota Semarang',
            'Kepala Bagian Organisasi Setda Kota Semarang',
            'Kepala Bagian Perekonomian dan SDA Setda Kota Semarang',
            'Kepala Bagian Administrasi Pembangunan Setda Kota Semarang',
            'Kepala Bagian Kesejahteraan Rakyat Setda Kota Semarang',
            'Kepala Bagian Pengadaan Barang/Jasa Setda Kota Semarang',
            'Kepala Bagian Komunikasi Pimpinan dan Protokol Setda Kota Semarang',
            'Kepala Bagian Tata Usaha Setda Kota Semarang',
            'Kepala Bagian Rumah Tangga Setda Kota Semarang',
            'Kepala Bagian Keuangan Setda Kota Semarang',
            'Camat Semarang Tengah',
            'Camat Semarang Barat',
            'Camat Semarang Utara',
            'Camat Semarang Timur',
            'Camat Semarang Selatan',
            'Camat Gayamsari',
            'Camat Genuk',
            'Camat Gunungpati',
            'Camat Gajah Mungkur',
            'Camat Banyumanik',
            'Camat Tugu',
            'Camat Ngaliyan',
            'Camat Tembalang',
            'Camat Pedurungan',
            'Camat Mijen',
            'Camat Candisari',
            'Direktur Utama PT Perumda Air Minum Tirta Moedal Kota Semarang',
            'Direktur Utama BPR BKK Kota Semarang',
            'Direktur PT Bhumi Pandanaran Sejahtera',
            'Direktur Utama BPR Bank Pasar Kota Semarang',
            'Direktur PT Taman Satwa Semarang',

        ];

        foreach ($data as $nama) {
            Tujuan::firstOrCreate([
                'nama' => trim($nama)
            ]);
        }
    }
}
