<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KepalaSekolah;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;


class KepalaSekolahController extends Controller
{
    public function index()
    {
        $kepalaSekolah = KepalaSekolah::with('user')->get();
        return view('pageadmin.kepalasekolah.index', compact('kepalaSekolah'));
    }

    public function create()
    {
        return view('pageadmin.kepalasekolah.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:255|unique:kepala_sekolahs',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // validasi foto dengan ekstensi dan ukuran maksimum
            'pendidikan_terakhir' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'role' => 'kepalasekolah',
            'password' => bcrypt($request->password),
        ]);

         // Upload foto
         $fotoPath = null;
         if ($request->hasFile('foto')) {
             $foto = $request->file('foto');
             $imageName = time() . '.' . $foto->getClientOriginalExtension();
             $fotoPath = 'profil/' . $imageName;
             $foto->move(public_path('profil'), $imageName);
         }

        KepalaSekolah::create([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'foto' => $fotoPath,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'user_id' => $user->id,
        ]);

        Alert::success('Success', 'Data Kepala Sekolah berhasil ditambahkan');
        return redirect('/kepala-sekolah');
    }

    public function edit($id)
    {
        $kepalaSekolah = KepalaSekolah::findOrFail($id);
        return view('pageadmin.kepalasekolah.edit', compact('kepalaSekolah'));
    }

    public function update(Request $request, $id)
    {
        $kepalaSekolah = KepalaSekolah::findOrFail($id);
        $user = User::findOrFail($kepalaSekolah->user_id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:255|unique:kepala_sekolahs,nip,' . $id,
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // foto opsional dengan validasi tambahan
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
            if (File::exists(public_path($kepalaSekolah->foto))) {
                File::delete(public_path($kepalaSekolah->foto));
            }

            $kepalaSekolah->foto = $fotoPath;
        }


        $user->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        $kepalaSekolah->update($request->all());

        Alert::success('Success', 'Data Kepala Sekolah berhasil diperbarui');
        return redirect('/kepala-sekolah');
    }

    public function destroy($id)
    {
        $kepalaSekolah = KepalaSekolah::findOrFail($id);
        $user = User::findOrFail($kepalaSekolah->user_id);
 // Hapus foto dari storage
 if (File::exists(public_path($kepalaSekolah->foto))) {
    File::delete(public_path($kepalaSekolah->foto));
}

        $kepalaSekolah->delete();
        $user->delete();

        Alert::success('Success', 'Data Kepala Sekolah berhasil dihapus');
        return redirect('/kepala-sekolah');
    }
}
