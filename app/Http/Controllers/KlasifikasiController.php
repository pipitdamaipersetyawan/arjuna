<?php

namespace App\Http\Controllers;

use App\Models\Klasifikasi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\KlasifikasiImport;

class KlasifikasiController extends Controller
{

    // halaman klasifikasi (tree)
    public function index()
{
    $data = Klasifikasi::whereNull('parent_id')
        ->with('children.children.children.children.children')
        ->orderBy('kode')
        ->get();

    return view('pages.master.klasifikasi', compact('data'));
}


    // import excel klasifikasi
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);

        Excel::import(new KlasifikasiImport, $request->file('file'));

        return redirect()
            ->back()
            ->with('success','Data klasifikasi berhasil diimport');
    }

}
