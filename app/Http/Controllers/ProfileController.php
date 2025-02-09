<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    // Fungsi untuk update profil (name, alamat, foto_profile)
    public function updateProfileUser(Request $request)
    {
        $user = Auth::user();

        // Validasi input untuk profile
        $request->validate([
            'name' => 'required|string|max:255',
            'alamat' => 'required|string|max:100',
            'file' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update data pengguna
        $user->name = $request->name;
        $user->alamat = $request->alamat;

        // Jika ada file foto profil yang diupload
        if ($request->hasFile('file')) {
            // Hapus foto profil lama jika ada
            if ($user->foto_profile) {
                Storage::delete('public/' . $user->foto_profile);
            }

            // Simpan foto profil baru
            $path = $request->file('file')->store('foto_profile', 'public');
            $user->foto_profile = $path;
        }

        $user->save();

        return redirect()->route('user.profile')->with('success', 'Profil berhasil diperbarui!');
    }

    // Fungsi untuk update password
    public function updatePasswordUser(Request $request)
    {
        $user = Auth::user();

        // Validasi input untuk password
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|confirmed|min:6',
        ]);

        // Verifikasi password lama
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama yang Anda masukkan tidak cocok.']);
        }

        // Update password pengguna
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('user.profile')->with('success', 'Password berhasil diperbarui!');
    }
}
