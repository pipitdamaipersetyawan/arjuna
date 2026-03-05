<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\Naskah;
use App\Models\Klasifikasi;
use App\Models\Pegawai;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $tahun = now()->year;

        // ===============================
        // NASKAH MASUK (TAHUN BERJALAN)
        // ===============================
       $naskahMasuk = SuratMasuk::count();

        // ===============================
        // NASKAH KELUAR (TAHUN BERJALAN)
        // ===============================
        $naskahKeluar = Naskah::whereYear('tanggal_surat', $tahun)->count();

        // ===============================
        // DISPOSISI NON AKTIF
        // ===============================
        $disposisi = 0;

        // ===============================
        // ARSIP INAKTIF
        // ===============================
        $arsipSuratMasuk = DB::table('surat_masuks')
            ->whereYear('tanggal_surat', '<', $tahun)
            ->count();

        $arsipNaskahKeluar = DB::table('naskahs')
            ->whereYear('tanggal_surat', '<', $tahun)
            ->count();

        $arsipAktif = $arsipSuratMasuk + $arsipNaskahKeluar;

        // ===============================
        // KLASIFIKASI
        // ===============================
        $klasifikasiInduk = Klasifikasi::whereNull('parent_id')->count();
        $klasifikasiSub   = Klasifikasi::whereNotNull('parent_id')->count();

        $kodeMin = Klasifikasi::min('kode');
        $kodeMax = Klasifikasi::max('kode');

        // ===============================
        // PEGAWAI
        // ===============================
        $pegawai = Pegawai::count();

        return view('dashboard', compact(
            'naskahMasuk',
            'naskahKeluar',
            'disposisi',
            'arsipAktif',
            'klasifikasiInduk',
            'klasifikasiSub',
            'kodeMin',
            'kodeMax',
            'pegawai'
        ));
    }

   public function statistik($jenis)
{
    $tahun = now()->year;

    $label = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    $type  = 'bar';

    if ($jenis == 'masuk') {

        $data = SuratMasuk::whereYear('tanggal_surat', $tahun)
            ->selectRaw('MONTH(tanggal_surat) as bulan, count(*) as jumlah')
            ->groupBy('bulan')
            ->pluck('jumlah');

        $judul = 'Grafik Surat Masuk';

    } elseif ($jenis == 'keluar') {

        $data = Naskah::whereYear('tanggal_surat', $tahun)
            ->selectRaw('MONTH(tanggal_surat) as bulan, count(*) as jumlah')
            ->groupBy('bulan')
            ->pluck('jumlah');

        $judul = 'Grafik Naskah Keluar';

    } elseif ($jenis == 'arsip') {

        $data = DB::table('surat_masuks')
            ->whereYear('tanggal_surat', '<', $tahun)
            ->selectRaw('MONTH(tanggal_surat) as bulan, count(*) as jumlah')
            ->groupBy('bulan')
            ->pluck('jumlah');

        $judul = 'Grafik Arsip Inaktif';

    } elseif ($jenis == 'pegawai') {

        $data = Pegawai::selectRaw('MONTH(created_at) as bulan, count(*) as jumlah')
            ->groupBy('bulan')
            ->pluck('jumlah');

        $judul = 'Grafik Pegawai';

    } elseif ($jenis == 'klasifikasi_induk') {

        $data = [
            Klasifikasi::whereNull('parent_id')->count(),
            Klasifikasi::whereNotNull('parent_id')->count()
        ];

        $label = ['Induk', 'Sub'];
        $judul = 'Perbandingan Klasifikasi';
        $type  = 'pie';

    } elseif ($jenis == 'klasifikasi_sub') {

        $data = [
            Klasifikasi::whereNotNull('parent_id')->count(),
            Klasifikasi::whereNull('parent_id')->count()
        ];

        $label = ['Sub', 'Induk'];
        $judul = 'Sub Klasifikasi';
        $type  = 'doughnut';

    } else {

        $data = [];
        $judul = 'Data tidak ditemukan';
    }

    // pastikan array 12 bulan untuk bar chart
    if ($type == 'bar') {
        $data = collect($data)->pad(12, 0);
    }

    return response()->json([
        'label' => $label,
        'jumlah' => $data,
        'judul'  => $judul

    ]);
}
}
