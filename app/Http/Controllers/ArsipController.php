<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ArsipController extends Controller
{

/*
|--------------------------------------------------------------------------
| ARSIP INAKTIF (TAHUN LAMA)
|--------------------------------------------------------------------------
*/

public function inaktif(Request $request)
{
    $tahun = now()->year;
    $perPage = $request->perPage ?? 10;

    // SURAT MASUK
    $suratMasuk = DB::table('surat_masuks')
        ->select(
            DB::raw("'Surat Masuk' as jenis"),
            'tanggal',
            'tanggal_surat',
            'nomor_surat',
            'surat_dari as pengirim',
            'isi_informasi as isi'
        )
        ->whereYear('tanggal', '<', $tahun);

    // NASKAH KELUAR
    $naskahKeluar = DB::table('naskahs')
        ->select(
            DB::raw("'Naskah Keluar' as jenis"),
            'created_at as tanggal',
            'tanggal_surat',
            'nomor_naskah as nomor_surat',
            'pengirim',
            'ringkasan as isi'
        )
        ->whereYear('tanggal_surat', '<', $tahun);

    // UNION
    $union = $suratMasuk->unionAll($naskahKeluar);

    $data = DB::query()->fromSub($union,'arsip');

    // SEARCH
    if ($request->filled('search')) {

        $data->where(function($q) use ($request){

            $q->where('nomor_surat','like','%'.$request->search.'%')
              ->orWhere('pengirim','like','%'.$request->search.'%')
              ->orWhere('isi','like','%'.$request->search.'%');

        });
    }

    $data = $data->orderBy('tanggal','asc')   // urut tanggal input lama → baru
                 ->paginate($perPage)
                 ->withQueryString();

    return view('pages.arsip.inaktif', compact('data'));
}


/*
|--------------------------------------------------------------------------
| ARSIP AKTIF (TAHUN BERJALAN)
|--------------------------------------------------------------------------
*/

public function aktif(Request $request)
{
    $tahun = now()->year;
    $perPage = $request->perPage ?? 10;

    // SURAT MASUK
    $suratMasuk = DB::table('surat_masuks')
        ->select(
            DB::raw("'Surat Masuk' as jenis"),
            'tanggal',
            'tanggal_surat',
            'nomor_surat',
            'surat_dari as pengirim',
            'isi_informasi as isi'
        )
        ->whereYear('tanggal', $tahun);

    // NASKAH KELUAR
    $naskahKeluar = DB::table('naskahs')
        ->select(
            DB::raw("'Naskah Keluar' as jenis"),
            'created_at as tanggal',
            'tanggal_surat',
            'nomor_naskah as nomor_surat',
            'pengirim',
            'ringkasan as isi'
        )
        ->whereYear('tanggal_surat', $tahun);

    // UNION
    $union = $suratMasuk->unionAll($naskahKeluar);

    $data = DB::query()->fromSub($union,'arsip');

    // SEARCH
    if ($request->filled('search')) {

        $data->where(function($q) use ($request){

            $q->where('nomor_surat','like','%'.$request->search.'%')
              ->orWhere('pengirim','like','%'.$request->search.'%')
              ->orWhere('isi','like','%'.$request->search.'%');

        });
    }

    $data = $data->orderBy('tanggal','asc')  // terbaru di atas
                 ->paginate($perPage)
                 ->withQueryString();

    return view('pages.arsip.aktif', compact('data'));
}

}
