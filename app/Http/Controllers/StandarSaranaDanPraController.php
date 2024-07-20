<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StandarSaranaDanPra;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

class StandarSaranaDanPraController extends Controller
{
    public function index()
    {
        $user = Auth::user();
    
        if ($user->role == 'guru') {
            // Untuk role 'guru', hanya menampilkan data yang ditambahkan oleh guru tersebut
            $StandarSaranaDanPra = StandarSaranaDanPra::where('user_id', $user->id)->get();
        } else {
            // Untuk role 'kepalasekolah' dan 'admin', menampilkan semua data
            $StandarSaranaDanPra = StandarSaranaDanPra::all();
        }
        return view('pageadmin.standarsaranadanpra.index', compact('StandarSaranaDanPra'));
    }
    

    public function create()
    {
        return view('pageadmin.standarsaranadanpra.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('standarsaranadanpra'), $fileName);
            $filePath = 'standarsaranadanpra/' . $fileName;
        }

        StandarSaranaDanPra::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_path' => $filePath,
            'user_id' => Auth::id(), // Menyimpan user_id dari user yang sedang login
        ]);

        Alert::success('Success', 'Standar sarana berhasil ditambahkan');
        return redirect('/standar-sarana');
    }

    public function edit($id)
    {
        $StandarSaranaDanPra = StandarSaranaDanPra::findOrFail($id);
        return view('pageadmin.standarsaranadanpra.edit', compact('StandarSaranaDanPra'));
    }

    public function update(Request $request, $id)
    {
        $StandarSaranaDanPra = StandarSaranaDanPra::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $filePath = $StandarSaranaDanPra->file_path;
        if ($request->hasFile('file')) {
            if ($filePath && file_exists(public_path($filePath))) {
                unlink(public_path($filePath));
            }
            $file = $request->file('file');
            $fileName = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('standarsaranadanpra'), $fileName);
            $filePath = 'standarsaranadanpra/' . $fileName;
        }

        $StandarSaranaDanPra->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_path' => $filePath,
            'user_id' => Auth::id(), // Menyimpan user_id dari user yang sedang login
        ]);

        Alert::success('Success', 'Standar sarana berhasil diperbarui');
        return redirect('/standar-sarana');
    }

    public function destroy($id)
    {
        $StandarSaranaDanPra = StandarSaranaDanPra::findOrFail($id);
        if ($StandarSaranaDanPra->file_path && file_exists(public_path($StandarSaranaDanPra->file_path))) {
            unlink(public_path($StandarSaranaDanPra->file_path));
        }
        $StandarSaranaDanPra->delete();

        Alert::success('Success', 'Standar sarana berhasil dihapus');
        return redirect('/standar-sarana');
    }
}
