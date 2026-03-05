<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index(Request $request)
    {
        $pegawais = Pegawai::when($request->search, function ($q) use ($request) {
            $q->where('nama', 'like', '%' . $request->search . '%')
              ->orWhere('nip', 'like', '%' . $request->search . '%');
        })->latest()->get();

        return view('pages.master.pegawai.index', compact('pegawais'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nip'  => 'required|numeric|digits:18|unique:pegawais,nip'
        ], [
            'nip.unique' => 'NIP sudah terdaftar'
        ]);

        Pegawai::create($request->only('nama', 'nip'));

        return back()->with('success', 'Data berhasil disimpan');
    }

    public function edit(Pegawai $pegawai, Request $request)
    {
        $pegawais = Pegawai::when($request->search, function ($q) use ($request) {
            $q->where('nama', 'like', '%' . $request->search . '%')
              ->orWhere('nip', 'like', '%' . $request->search . '%');
        })->latest()->get();

        return view('pages.master.pegawai.index', compact('pegawais', 'pegawai'));
    }

    public function update(Request $request, Pegawai $pegawai)
    {
        $request->validate([
            'nama' => 'required',
            'nip'  => 'required|numeric|digits:18|unique:pegawais,nip,' . $pegawai->id
        ]);

        $pegawai->update($request->only('nama', 'nip'));

        return redirect()->route('pegawai.index')
                         ->with('success', 'Data berhasil diupdate');
    }

    public function destroy(Pegawai $pegawai)
    {
        $pegawai->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }
}