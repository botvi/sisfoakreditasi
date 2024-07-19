<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataGuru;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;

class DataGuruController extends Controller
{
    public function index()
    {
        $dataGurus = DataGuru::with('user')->get();
        return view('pageadmin.dataguru.index', compact('dataGurus'));
    }

    public function create()
    {
        return view('pageadmin.dataguru.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:255|unique:data_gurus',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // validasi foto dengan ekstensi dan ukuran maksimum
            'jabatan' => 'required|string|max:255',
            'pendidikan_terakhir' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        // Simpan user baru
        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'role' => 'guru',
            'password' => bcrypt($request->password),
        ]);
    
        // Upload foto jika ada
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $imageName = time() . '.' . $foto->getClientOriginalExtension();
            $fotoPath = 'profil/' . $imageName;
            $foto->move(public_path('profil'), $imageName);
        }
    
        // Simpan data guru baru
        DataGuru::create([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'foto' => $fotoPath, // bisa null jika tidak ada foto yang diupload
            'jabatan' => $request->jabatan,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'user_id' => $user->id,
        ]);
    
        Alert::success('Success', 'Data Guru berhasil ditambahkan');
        return redirect('/data-gurus');
    }
    

    public function edit($id)
    {
        $dataGuru = DataGuru::findOrFail($id);
        return view('pageadmin.dataguru.edit', compact('dataGuru'));
    }

    public function update(Request $request, $id)
    {
        $dataGuru = DataGuru::findOrFail($id);
        $user = User::findOrFail($dataGuru->user_id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:255|unique:data_gurus,nip,' . $id,
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // foto opsional dengan validasi tambahan
            'jabatan' => 'required|string|max:255',
            'pendidikan_terakhir' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update foto jika ada
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $imageName = time() . '.' . $foto->getClientOriginalExtension();
            $fotoPath = 'profil/' . $imageName;
            $foto->move(public_path('profil'), $imageName);

            // Hapus foto lama
            if (File::exists(public_path($dataGuru->foto))) {
                File::delete(public_path($dataGuru->foto));
            }

            $dataGuru->foto = $fotoPath;
        }

        // Update informasi user
        $user->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        // Update informasi data guru
        $dataGuru->update([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'jabatan' => $request->jabatan,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
        ]);

        Alert::success('Success', 'Data Guru berhasil diperbarui');
        return redirect('/data-gurus');
    }

    public function destroy($id)
    {
        $dataGuru = DataGuru::findOrFail($id);
        $user = User::findOrFail($dataGuru->user_id);

        // Hapus foto dari storage
        if (File::exists(public_path($dataGuru->foto))) {
            File::delete(public_path($dataGuru->foto));
        }

        // Hapus data guru dan user
        $dataGuru->delete();
        $user->delete();

        Alert::success('Success', 'Data Guru berhasil dihapus');
        return redirect('/data-gurus');
    }
}
