<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SuratMasuk;
use App\Models\Naskah;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\SvgWriter;

use App\Exports\SuratMasukExport;
use App\Exports\NaskahKeluarExport;
use App\Exports\ArsipExport;

class LaporanController extends Controller
{

/*
|--------------------------------------------------------------------------
| ================= SURAT MASUK =================
|--------------------------------------------------------------------------
*/

private function filterSuratMasuk(Request $request)
{
    $query = SuratMasuk::query();

    if ($request->filled('start') && $request->filled('end')) {
        $query->whereBetween('tanggal_surat', [
            $request->start,
            $request->end
        ]);
    }

    if ($request->filled('search')) {

        $search = $request->search;

        $query->where(function ($q) use ($search) {

            $q->where('nomor_surat', 'like', "%$search%")
              ->orWhere('surat_dari', 'like', "%$search%")
              ->orWhere('isi_informasi', 'like', "%$search%");

        });

    }

    return $query;
}


public function suratMasuk(Request $request)
{
    Carbon::setLocale('id');

    $data = $this->filterSuratMasuk($request)
        ->orderBy('tanggal_surat','asc')
        ->paginate(10)
        ->withQueryString();

    return view('pages.laporan.surat-masuk', compact('data'));
}


public function suratMasukPdf(Request $request)
{

$data = $this->filterSuratMasuk($request)
    ->orderBy('tanggal_surat','asc')
    ->get();

$rows = $data->values()->map(function($d,$i){

return [

$i + 1,

Carbon::parse($d->tanggal)->format('d F Y'),

$d->surat_dari,

Carbon::parse($d->tanggal_surat)->format('d F Y'),

$d->nomor_surat,

$d->isi_informasi,

$d->klasifikasi_kode,

$d->keterangan ?? '-'

];

});

$pdf = Pdf::loadView(
'pages.laporan.pdf-surat-masuk',
[
'rows' => $rows
]
);

return $pdf->download('laporan-surat-masuk.pdf');

}


public function suratMasukExcel(Request $request)
{

$data = $this->filterSuratMasuk($request)
    ->orderBy('tanggal_surat','asc')
    ->get();

return Excel::download(
    new SuratMasukExport($data),
    'laporan-surat-masuk.xlsx'
);

}


/*
|--------------------------------------------------------------------------
| ================= NASKAH KELUAR =================
|--------------------------------------------------------------------------
*/


private function filterNaskahKeluar(Request $request)
{

$query = Naskah::query();

if ($request->filled('start') && $request->filled('end')) {

$query->whereBetween('tanggal_surat', [
$request->start,
$request->end
]);

}

if ($request->filled('search')) {

$search = $request->search;

$query->where(function ($q) use ($search) {

$q->where('nomor_naskah','like',"%$search%")
->orWhere('pengirim','like',"%$search%")
->orWhere('hal','like',"%$search%");

});

}

return $query;

}


public function naskahKeluar(Request $request)
{

$data = $this->filterNaskahKeluar($request)
->with('tujuan')
->orderBy('tanggal_surat','asc')
->paginate(10)
->withQueryString();

return view('pages.laporan.naskah-keluar', compact('data'));

}


public function naskahKeluarCetak(Request $request)
{

$data = $this->filterNaskahKeluar($request)
->with('tujuan')
->orderBy('tanggal_surat','asc')
->get();

return view('pages.laporan.cetak-naskah-keluar', compact('data'));

}


public function naskahKeluarPdf(Request $request)
{

$data = $this->filterNaskahKeluar($request)
->with('tujuan')
->orderBy('tanggal_surat','asc')
->get();


$urlValidasi = route('laporan.naskah-keluar', $request->query());


$qr = new QrCode(
data: $urlValidasi,
size: 150,
margin: 10
);

$writer = new SvgWriter();
$result = $writer->write($qr);

$qrCode = base64_encode($result->getString());


$pdf = Pdf::loadView(
'pages.laporan.pdf-naskah-keluar',
compact('data','qrCode')
);


$pdf->setPaper('A4', count($data) > 12 ? 'landscape' : 'portrait');


return $pdf->download('laporan-naskah-keluar.pdf');

}


public function naskahKeluarExcel(Request $request)
{

$data = $this->filterNaskahKeluar($request)
->with('tujuan')
->orderBy('tanggal_surat','asc')
->get();

return Excel::download(
new NaskahKeluarExport($data),
'laporan-naskah-keluar.xlsx'
);

}



/*
|--------------------------------------------------------------------------
| ================= ARSIP =================
|--------------------------------------------------------------------------
*/


private function filterArsip(Request $request)
{

$tahun = now()->year;


$suratMasuk = DB::table('surat_masuks')
->select(
DB::raw("'Surat Masuk' as jenis"),
'tanggal',
'tanggal_surat',
'nomor_surat',
'surat_dari as pengirim',
'isi_informasi as isi',
'klasifikasi_kode'
)
->whereYear('tanggal','<',$tahun);


$naskahKeluar = DB::table('naskahs')
->select(
DB::raw("'Naskah Keluar' as jenis"),
'created_at as tanggal',
'tanggal_surat',
'nomor_naskah as nomor_surat',
'pengirim',
'hal as isi',
'klasifikasi_kode'
)
->whereYear('tanggal_surat','<',$tahun);


$union = $suratMasuk->unionAll($naskahKeluar);

$query = DB::query()->fromSub($union,'arsip');


if ($request->filled('search')) {

$search = $request->search;

$query->where(function($q) use ($search){

$q->where('nomor_surat','like',"%$search%")
->orWhere('pengirim','like',"%$search%")
->orWhere('isi','like',"%$search%");

});

}


return $query;

}



public function arsip(Request $request)
{

$data = $this->filterArsip($request)
->orderBy('tanggal_surat','asc')
->paginate(10)
->withQueryString();

return view('pages.laporan.arsip', compact('data'));

}


public function arsipPdf(Request $request)
{

$data = $this->filterArsip($request)
->orderBy('tanggal_surat','asc')
->get();


$rows = $data->values()->map(function($d,$i){

return [

$i + 1,

$d->jenis,

Carbon::parse($d->tanggal_surat)->format('d M Y'),

$d->nomor_surat,

$d->pengirim,

$d->isi

];

});


$pdf = Pdf::loadView(
'pages.laporan.pdf-arsip',
[
'rows' => $rows
]
);


return $pdf->download('laporan-arsip.pdf');

}


public function arsipExcel(Request $request)
{

$data = $this->filterArsip($request)
->orderBy('tanggal_surat','asc')
->get();

return Excel::download(
new ArsipExport($data),
'laporan-arsip-inaktif.xlsx'
);

}

}
