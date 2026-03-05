<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratMasuk;
use Illuminate\Support\Facades\Storage;
use App\Models\Klasifikasi;

class SuratMasukController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | FORM INPUT (HALAMAN UTAMA SURAT MASUK)
    |--------------------------------------------------------------------------
    */
     public function create()
    {
        $klasifikasi = Klasifikasi::orderBy('kode')->get();
        return view('pages.surat-masuk.create', compact('klasifikasi'));
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN DATA
    |--------------------------------------------------------------------------
    */
   public function store(Request $request)
{
    $request->validate([
        'tanggal'           => 'required|date',
        'klasifikasi_kode'  => 'required',
        'surat_dari'        => 'required',
        'tanggal_surat'     => 'required|date',
        'nomor_surat'       => 'required|unique:surat_masuks,nomor_surat',
        'isi_informasi'     => 'required',
        'file_surat'        => 'nullable|file|mimes:pdf,docx,xlsx,pptx|max:2048'
    ]);

    // NOMOR AGENDA OTOMATIS
    $tahun = date('Y', strtotime($request->tanggal));
    $lastNo = SuratMasuk::whereYear('tanggal', $tahun)->max('no_agenda');
    $noAgenda = $lastNo ? $lastNo + 1 : 1;

    // UPLOAD FILE
    $filePath = null;
    if ($request->hasFile('file_surat')) {
        $filePath = $request->file('file_surat')->store('surat-masuk', 'public');
    }

    // SIMPAN DATA
    SuratMasuk::create([
        'tanggal'           => $request->tanggal,
        'klasifikasi_kode'  => $request->klasifikasi_kode,
        'surat_dari'        => $request->surat_dari,
        'tanggal_surat'     => $request->tanggal_surat,
        'nomor_surat'       => $request->nomor_surat,
        'isi_informasi'     => $request->isi_informasi,
        'no_agenda'         => $noAgenda,
        'keterangan'        => $request->keterangan,
        'file'              => $filePath
    ]);

    return redirect()->route('surat-masuk.riwayat')
                     ->with('success','Surat masuk berhasil disimpan 🎉');
}
    /*
    |--------------------------------------------------------------------------
    | RIWAYAT SURAT (OPSIONAL - UNTUK MENU RIWAYAT)
    |--------------------------------------------------------------------------
    */
  public function riwayat(Request $request)
{
   $query = \App\Models\SuratMasuk::whereYear('tanggal', now()->year);

    // 🔍 cari nomor surat
    if ($request->nomor) {
        $query->where('nomor_surat', 'like', '%' . $request->nomor . '%');
    }

    // 🔍 cari asal surat
    if ($request->asal_surat) {
        $query->where('surat_dari', 'like', '%' . $request->asal_surat . '%');
    }

    // 🔍 cari isi informasi
    if ($request->informasi) {
        $query->where('isi_informasi', 'like', '%' . $request->informasi . '%');
    }

    // 🔍 cari klasifikasi
    if ($request->klasifikasi) {
        $query->where('klasifikasi_kode', 'like', '%' . $request->klasifikasi . '%');
    }

    // 📅 filter tanggal surat
    if ($request->tgl_awal && $request->tgl_akhir) {
        $query->whereBetween('tanggal_surat', [
            $request->tgl_awal,
            $request->tgl_akhir
        ]);
    }

    // 📅 filter tanggal input (kolom: tanggal)
    if ($request->input_awal && $request->input_akhir) {
        $query->whereBetween('tanggal', [
            $request->input_awal,
            $request->input_akhir
        ]);
    }

    // 📄 jumlah data tampil
    $perPage = $request->perPage ?? 10;

    $data = $query->orderBy('tanggal', 'asc')
              ->orderBy('no_agenda', 'asc')
              ->paginate($perPage)
              ->withQueryString();

    return view('pages.surat-masuk.riwayat', compact('data'));
}

 /*
    |--------------------------------------------------------------------------
    | EDIT DATA
    |--------------------------------------------------------------------------
    */

 public function edit($id)
{
    $data = SuratMasuk::findOrFail($id);
    $klasifikasi = Klasifikasi::orderBy('kode')->get();

    return view('pages.surat-masuk.create', compact('data','klasifikasi'));
}

 /*
    |--------------------------------------------------------------------------
    | UPDATE DATA
    |--------------------------------------------------------------------------
    */

public function update(Request $request, $id)
{
    $data = SuratMasuk::findOrFail($id);

    $request->validate([
        'tanggal'          => 'required|date',
        'klasifikasi_kode' => 'required',
        'surat_dari'       => 'required',
        'tanggal_surat'    => 'required|date',
        'nomor_surat'      => 'required|unique:surat_masuks,nomor_surat,' . $id,
        'isi_informasi'    => 'required',
        'file_surat'       => 'nullable|file|mimes:pdf,docx,xlsx,pptx|max:2048'
    ]);

    /*
    |-----------------------------
    | HANDLE FILE (OPTIONAL)
    |-----------------------------
    */
    $filePath = $data->file;

    if ($request->hasFile('file_surat')) {

        // hapus file lama
        if ($data->file && Storage::disk('public')->exists($data->file)) {
            Storage::disk('public')->delete($data->file);
        }

        // upload file baru
        $filePath = $request->file('file_surat')
                            ->store('surat-masuk', 'public');
    }

    /*
    |-----------------------------
    | UPDATE DATA
    |-----------------------------
    */
    $data->update([
        'tanggal'          => $request->tanggal,
        'tanggal_surat'    => $request->tanggal_surat,
        'nomor_surat'      => $request->nomor_surat,
        'surat_dari'       => $request->surat_dari,
        'isi_informasi'    => $request->isi_informasi,
        'klasifikasi_kode' => $request->klasifikasi_kode,
        'keterangan'       => $request->keterangan,
        'file'             => $filePath,
    ]);

    return redirect()->route('surat-masuk.riwayat')
                     ->with('success','Data berhasil diupdate');
}

    /*
    |--------------------------------------------------------------------------
    | HAPUS DATA
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $data = SuratMasuk::findOrFail($id);

        if ($data->file && Storage::disk('public')->exists($data->file)) {
            Storage::disk('public')->delete($data->file);
        }

        $data->delete();

        return back()->with('success', 'Surat masuk berhasil dihapus 🗑️');
    }

/*
    |--------------------------------------------------------------------------
    |CARI DATA
    |--------------------------------------------------------------------------
    */


    public function index(Request $request)
{
    $query = SuratMasuk::query();

    // 🔍 nomor surat
    if ($request->nomor) {
        $query->where('nomor_surat', 'like', '%' . $request->nomor . '%');
    }

    // 🔍 asal surat
if ($request->asal_surat) {
    $query->where('surat_dari', 'like', '%' . $request->asal_surat . '%');
}

// 🔍 informasi
if ($request->informasi) {
    $query->where('isi_informasi', 'like', '%' . $request->informasi . '%');
}

    // 🔍 klasifikasi
    if ($request->klasifikasi) {
        $query->where('klasifikasi_kode', 'like', '%' . $request->klasifikasi . '%');
    }

    // 📅 tanggal surat
    if ($request->tgl_awal && $request->tgl_akhir) {
        $query->whereBetween('tanggal_surat', [
            $request->tgl_awal,
            $request->tgl_akhir
        ]);
    }

    // 📅 tanggal input
    if ($request->input_awal && $request->input_akhir) {
        $query->whereBetween('created_at', [
            $request->input_awal,
            $request->input_akhir
        ]);
    }

    // 📄 jumlah data tampil
    $perPage = $request->perPage ?? 10;

    $surat = $query->latest()
                   ->paginate($perPage)
                   ->withQueryString();

    return view('pages.surat-masuk.index', compact('surat'));
}
}
