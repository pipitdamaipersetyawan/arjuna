<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        // ✅ VALIDASI
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        // ✅ UPDATE DATA USER LOGIN
        $request->user()->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        // ✅ KEMBALI KE HALAMAN PROFIL
        return back()->with('success', 'Profil berhasil diperbarui');
    }
}