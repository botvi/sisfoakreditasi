<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class UserController extends Controller
{
    // Metode untuk menampilkan halaman profil
    public function show()
    {
        return view('pageadmin.profil.index', ['user' => Auth::user()]);
    }

    // Metode untuk memperbarui profil pengguna
    public function update(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . Auth::id(),
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'alamat' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Mendapatkan pengguna yang sedang login
        $user = Auth::user();

        // Memperbarui informasi pengguna
        $updateData = [
            'nama' => $request->input('nama'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'alamat' => $request->input('alamat'),
        ];

        // Memperbarui kata sandi jika diisi
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->input('password'));
        }

        // Memperbarui foto jika ada
        if ($request->hasFile('foto')) {
            // Menghapus foto lama jika ada
            if ($user->foto) {
                Storage::delete('profil/' . basename($user->foto));
            }

            // Menyimpan foto baru
            $foto = $request->file('foto');
            $fotoName = time() . '_' . $foto->getClientOriginalName();
            $foto->move(public_path('profil'), $fotoName);
            $updateData['foto'] = 'profil/' . $fotoName;
        }

        // Menyimpan perubahan menggunakan update()
        User::where('id', $user->id)->update($updateData);

        // Mengirim respons
        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}
