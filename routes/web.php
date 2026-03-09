<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\KlasifikasiController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\NaskahController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\ArsipController;
use App\Http\Controllers\LaporanController;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\KlasifikasiImport;
use App\Imports\KlasifikasiUpdateNamaImport;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| HALAMAN AWAL
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| GOOGLE LOGIN
|--------------------------------------------------------------------------
*/
Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

/*
|--------------------------------------------------------------------------
| AREA SETELAH LOGIN
|--------------------------------------------------------------------------
*/
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/statistik/{jenis}', [DashboardController::class, 'statistik'])->name('dashboard.statistik');

    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */
    Route::view('/profile', 'profile.show')->name('profile.show');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    /*
    |--------------------------------------------------------------------------
    | SURAT MASUK
    |--------------------------------------------------------------------------
    */
   Route::prefix('surat-masuk')->name('surat-masuk.')->group(function () {

    Route::get('/', [SuratMasukController::class, 'create'])->name('index'); // langsung form
    Route::get('/create', [SuratMasukController::class, 'create'])->name('create');
    Route::post('/', [SuratMasukController::class, 'store'])->name('store');

    Route::get('/riwayat', [SuratMasukController::class, 'riwayat'])->name('riwayat');

    Route::get('/{id}/edit', [SuratMasukController::class, 'edit'])
        ->whereNumber('id')
        ->name('edit');

    Route::put('/{id}', [SuratMasukController::class, 'update'])
        ->whereNumber('id')
        ->name('update');

    Route::delete('/{id}', [SuratMasukController::class, 'destroy'])
        ->whereNumber('id')
        ->name('destroy');
});

    /*
    |--------------------------------------------------------------------------
    | SURAT KELUAR / NASKAH
    |--------------------------------------------------------------------------
    */
  Route::prefix('naskah')->name('naskah.')->group(function () {

    Route::get('/', [NaskahController::class, 'index'])->name('index');
    Route::get('/buat', [NaskahController::class, 'create'])->name('create');
    Route::post('/', [NaskahController::class, 'store'])->name('store');

    // 🔥 TAMBAHKAN INI
    Route::get('/{id}', [NaskahController::class, 'show'])
        ->whereNumber('id')
        ->name('show');

    Route::get('/{id}/edit', [NaskahController::class, 'edit'])
        ->whereNumber('id')
        ->name('edit');

    Route::put('/{id}', [NaskahController::class, 'update'])
        ->whereNumber('id')
        ->name('update');

    Route::delete('/{id}', [NaskahController::class, 'destroy'])
        ->whereNumber('id')
        ->name('destroy');
});

    /*
    |--------------------------------------------------------------------------
    | ARSIP
    |--------------------------------------------------------------------------
    */
   Route::get('/arsip/aktif', [ArsipController::class,'aktif'])->name('arsip.aktif');
    Route::get('/arsip/inaktif', [ArsipController::class,'inaktif'])->name('arsip.inaktif');
    Route::get('/retensi', fn() => view('pages.arsip.retensi'))->name('retensi.index');

    /*
|--------------------------------------------------------------------------
| LAPORAN
|--------------------------------------------------------------------------
*/
Route::prefix('laporan')->name('laporan.')->group(function () {

    /*
    |---------------- SURAT MASUK ----------------
    */
    Route::get('/surat-masuk', [LaporanController::class,'suratMasuk'])
        ->name('surat-masuk');

    Route::get('/surat-masuk/pdf', [LaporanController::class,'suratMasukPdf'])
        ->name('surat-masuk.pdf');

    Route::get('/surat-masuk/excel', [LaporanController::class,'suratMasukExcel'])
        ->name('surat-masuk.excel');


    /*
|---------------- NASKAH KELUAR ----------------
*/
Route::get('/naskah-keluar', [LaporanController::class,'naskahKeluar'])
    ->name('naskah-keluar');

Route::get('/naskah-keluar/cetak', [LaporanController::class,'naskahKeluarCetak'])
    ->name('naskah-keluar.cetak');

Route::get('/naskah-keluar/pdf', [LaporanController::class,'naskahKeluarPdf'])
    ->name('naskah-keluar.pdf');

Route::get('/naskah-keluar/excel', [LaporanController::class,'naskahKeluarExcel'])
    ->name('naskah-keluar.excel');
   /*
|---------------- ARSIP ----------------
*/
Route::get('/arsip', [LaporanController::class,'arsip'])->name('arsip');

Route::get('/arsip/pdf', [LaporanController::class,'arsipPdf'])->name('arsip.pdf');

Route::get('/arsip/excel', [LaporanController::class,'arsipExcel'])->name('arsip.excel');
});

    /*
    |--------------------------------------------------------------------------
    | PENGATURAN
    |--------------------------------------------------------------------------
    */
    Route::get('/klasifikasi', [KlasifikasiController::class, 'index'])
    ->name('klasifikasi.index');

/* 🔥 TAMBAHAN ROUTE IMPORT */
Route::post('/klasifikasi/import', [KlasifikasiController::class, 'import'])
    ->name('klasifikasi.import');

Route::view('/unit-kerja', 'pages.master.unit-kerja')
    ->name('unit-kerja.index');

Route::resource('/pegawai', PegawaiController::class)
    ->middleware('breadcrumb:Pengaturan,Pegawai');

Route::delete('/pegawai-mass-delete', [PegawaiController::class, 'massDelete'])
    ->name('pegawai.massDelete');
});

/*
|--------------------------------------------------------------------------
| IMPORT EXCEL (DIAMANKAN)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/import-klasifikasi', function () {
        Excel::import(new KlasifikasiImport, public_path('kode_arsip.xlsx'));
        return 'Import klasifikasi berhasil ✅';
    });

    Route::get('/fix-nama-klasifikasi', function () {
        Excel::import(new KlasifikasiUpdateNamaImport, public_path('kode_arsip.xlsx'));
        return 'Nama klasifikasi berhasil diupdate ✅';
    });

});

/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/
Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::get('/fixdb', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('migrate', ['--force' => true]);
    return 'Database migration berhasil';
});

Route::get('/clear', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    return 'Config cleared';
});
