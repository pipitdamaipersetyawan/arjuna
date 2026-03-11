<?php

namespace App\Http\Controllers;


use App\Models\Naskah;
use App\Models\Klasifikasi;
use App\Models\Tujuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NaskahController extends Controller
{
    public function create()
{
    $klasifikasi = Klasifikasi::all();

    // ✅ DATA MASTER TUJUAN DEFAULT
    $defaultTujuan = [
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

    // ✅ AUTO INSERT KE DB JIKA BELUM ADA
    foreach ($defaultTujuan as $nama) {
        Tujuan::firstOrCreate(['nama' => $nama]);
    }

   $listTujuan = Tujuan::orderBy('nama')->get()->groupBy(function ($item) {

    if (str_contains($item->nama, 'Dinas')) return 'DINAS';

    if (str_contains($item->nama, 'Bagian')) return 'BAGIAN SETDA';

    if (str_contains($item->nama, 'Camat')) return 'KECAMATAN';

    if (str_contains($item->nama, 'Direktur')) return 'BUMD';

    return 'PEJABAT';
});

    return view('pages.naskah.create', compact('klasifikasi','listTujuan'));
}

   public function store(Request $request)
{
    $request->validate([
        'tanggal_surat'    => 'required|date',
        'nomor_naskah'     => ['required','regex:/^[A-Za-z0-9\/\.\-]+$/'],
        'jenis_naskah'     => 'required',
        'sifat_naskah'     => 'required',
        'klasifikasi_kode' => 'required',
        'hal'              => 'required',
        'ringkasan'        => 'required',
        'file_naskah'      => 'nullable|file|mimes:pdf,doc,docx,pptx,xlsx|max:2048'
    ]);

    $nomor  = $request->nomor_naskah;
    $tahun  = date('Y', strtotime($request->tanggal_surat));
    $noUrut = null;

    if ($nomor !== '-') {
        $pecah  = explode('/', $nomor);
        $noUrut = $pecah[1] ?? $pecah[0] ?? null;

        if ($noUrut && Naskah::where('no_urut', $noUrut)
                ->whereYear('tanggal_surat', $tahun)
                ->exists()) {

            return back()->withErrors([
                'nomor_naskah' => "Nomor urut $noUrut sudah digunakan di tahun $tahun ✨"
            ])->withInput();
        }
    }

    $filePath = null;

    if ($request->hasFile('file_naskah')) {
        $filePath = $request->file('file_naskah')->store('naskah','public');
    }

    $naskah = Naskah::create([
        'tanggal_surat'    => $request->tanggal_surat,
        'pengirim'         => 'Bagian Administrasi Pembangunan',
        'jenis_naskah'     => $request->jenis_naskah,
        'sifat_naskah'     => $request->sifat_naskah,
        'kode_sifat'       => $request->sifat_naskah,
        'klasifikasi_kode' => $request->klasifikasi_kode,
        'nomor_naskah'     => $nomor,
        'no_urut'          => $noUrut,
        'hal'              => $request->hal,
        'ringkasan'        => $request->ringkasan,
        'file'             => $filePath,
    ]);

    // ===============================
    // ✅ SIMPAN TUJUAN
    // ===============================

    $tujuanIds = [];
    $manualTujuan = [];

    if ($request->tujuan) {

        foreach ($request->tujuan as $t) {

            if (is_numeric($t)) {
                $tujuanIds[] = $t;
            } else {
                $manualTujuan[] = $t;
            }
        }
    }

    $naskah->tujuan()->syncWithoutDetaching($tujuanIds);

    $naskah->update([
        'tujuan_manual' => implode(', ', $manualTujuan)
    ]);

    return redirect()->route('naskah.index')
        ->with('success','Naskah berhasil disimpan 🎉');
}
    public function index(Request $request)
{
    $tahun = now()->year;
$query = Naskah::with('tujuan')
        ->whereYear('tanggal_surat', $tahun);

    // 🔍 filter nomor
    if ($request->nomor) {
        $query->where('nomor_naskah', 'like', '%' . $request->nomor . '%');
    }

    // 🔍 filter hal
    if ($request->hal) {
        $query->where('hal', 'like', '%' . $request->hal . '%');
    }

    // 🔍 filter jenis
    if ($request->jenis) {
        $query->where('jenis_naskah', 'like', '%' . $request->jenis . '%');
    }

    // 🔍 filter klasifikasi
    if ($request->klasifikasi) {
        $query->where('klasifikasi_kode', 'like', '%' . $request->klasifikasi . '%');
    }

    if ($request->tujuan) {
    $query->whereHas('tujuan', function ($q) use ($request) {
        $q->where('nama', 'like', '%' . $request->tujuan . '%');
    });
}

    // ✅ filter tanggal
    if ($request->tgl_awal && $request->tgl_akhir) {
        $query->whereBetween('tanggal_surat', [
            $request->tgl_awal,
            $request->tgl_akhir
        ]);
    }

    // ✅ jumlah data per halaman
    $perPage = $request->perPage ?? 10;

    $naskah = $query->orderBy('tanggal_surat', 'asc')
                    ->paginate($perPage)
                    ->withQueryString();

    return view('pages.naskah.index', compact('naskah'));
}

   public function edit($id)
{
    $naskah = Naskah::with('tujuan')->findOrFail($id);
    $klasifikasi = Klasifikasi::orderBy('kode')->get();

    $listTujuan = Tujuan::orderBy('nama')->get()->groupBy(function ($item) {

        if (str_contains($item->nama, 'Dinas')) return 'DINAS';
        if (str_contains($item->nama, 'Bagian')) return 'BAGIAN SETDA';
        if (str_contains($item->nama, 'Camat')) return 'KECAMATAN';
        if (str_contains($item->nama, 'Direktur')) return 'BUMD';

        return 'PEJABAT';
    });

    return view('pages.naskah.edit', compact('naskah','klasifikasi','listTujuan'));
}

    public function update(Request $request, $id)
    {
        $item = Naskah::findOrFail($id);

        $request->validate([
            'tanggal_surat'    => 'required|date',
            'nomor_naskah'     => ['required','regex:/^[A-Za-z0-9\/\.\-]+$/'],
            'jenis_naskah'     => 'required',
            'sifat_naskah'     => 'required',
            'klasifikasi_kode' => 'required',
            'hal'              => 'required',
            'ringkasan'        => 'required',
            'file_naskah'      => 'nullable|file|mimes:pdf,doc,docx,pptx,xlsx|max:2048'
        ]);

        $nomor  = $request->nomor_naskah;
        $tahun  = date('Y', strtotime($request->tanggal_surat));
        $noUrut = null;

        if ($nomor !== '-') {
            $pecah  = explode('/', $nomor);
            $noUrut = $pecah[1] ?? $pecah[0] ?? null;

            if ($noUrut && Naskah::where('no_urut', $noUrut)
                    ->whereYear('tanggal_surat', $tahun)
                    ->where('id','!=',$id)
                    ->exists()) {

                return back()->withErrors([
                    'nomor_naskah' => "Nomor urut <b>$noUrut</b> sudah digunakan di tahun $tahun ✨"
                ])->withInput();
            }
        }

        $filePath = $item->file;

        if ($request->hasFile('file_naskah')) {

            if ($item->file && Storage::disk('public')->exists($item->file)) {
                Storage::disk('public')->delete($item->file);
            }

           $file = $request->file('file_naskah');

$namaFile = time().'_'.$file->getClientOriginalName();

$file->move(public_path('storage/naskah'), $namaFile);

$filePath = 'naskah/'.$namaFile;
        }

        $item->update([
            'tanggal_surat'    => $request->tanggal_surat,
            'jenis_naskah'     => $request->jenis_naskah,
            'sifat_naskah'     => $request->sifat_naskah,
            'kode_sifat'       => $request->sifat_naskah,
            'klasifikasi_kode' => $request->klasifikasi_kode,
            'nomor_naskah'     => $nomor,
            'no_urut'          => $noUrut,
            'hal'              => $request->hal,
            'ringkasan'        => $request->ringkasan,
            'file'             => $filePath,
        ]);

        // ===============================
// ✅ UPDATE TUJUAN
// ===============================

$tujuanIds = [];
$manualTujuan = [];

if ($request->tujuan) {

    foreach ($request->tujuan as $t) {

        if (is_numeric($t)) {
            $tujuanIds[] = $t;
        } else {
            $manualTujuan[] = $t;
        }
    }
}

$item->tujuan()->sync($tujuanIds);

$item->update([
    'tujuan_manual' => implode(', ', $manualTujuan)
]);
        return redirect()->route('naskah.index')
            ->with('success','Naskah berhasil diupdate 🎉');
    }

    public function destroy($id)
    {
        $data = Naskah::findOrFail($id);

        if ($data->file && Storage::disk('public')->exists($data->file)) {
            Storage::disk('public')->delete($data->file);
        }

        $data->delete();

        return back()->with('success','Naskah berhasil dihapus 🗑️');
    }
}
