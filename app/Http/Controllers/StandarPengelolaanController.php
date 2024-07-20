<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StandarPengelolaan;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

class StandarPengelolaanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
    
        if ($user->role == 'guru') {
            // Untuk role 'guru', hanya menampilkan data yang ditambahkan oleh guru tersebut
            $standarPengelolaan = StandarPengelolaan::where('user_id', $user->id)->get();
        } else {
            // Untuk role 'kepalasekolah' dan 'admin', menampilkan semua data
            $standarPengelolaan = StandarPengelolaan::all();
        }
        return view('pageadmin.standarpengelolaan.index', compact('standarPengelolaan'));
    }
    

    public function create()
    {
        return view('pageadmin.standarpengelolaan.create');
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
            $file->move(public_path('standarpengelolaan'), $fileName);
            $filePath = 'standarpengelolaan/' . $fileName;
        }

        StandarPengelolaan::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_path' => $filePath,
            'user_id' => Auth::id(), // Menyimpan user_id dari user yang sedang login
        ]);

        Alert::success('Success', 'Standar pengelolaan berhasil ditambahkan');
        return redirect('/standar-pengelolaan');
    }

    public function edit($id)
    {
        $standarPengelolaan = StandarPengelolaan::findOrFail($id);
        return view('pageadmin.standarpengelolaan.edit', compact('standarPengelolaan'));
    }

    public function update(Request $request, $id)
    {
        $standarPengelolaan = StandarPengelolaan::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $filePath = $standarPengelolaan->file_path;
        if ($request->hasFile('file')) {
            if ($filePath && file_exists(public_path($filePath))) {
                unlink(public_path($filePath));
            }
            $file = $request->file('file');
            $fileName = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('standarpengelolaan'), $fileName);
            $filePath = 'standarpengelolaan/' . $fileName;
        }

        $standarPengelolaan->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_path' => $filePath,
            'user_id' => Auth::id(), // Menyimpan user_id dari user yang sedang login
        ]);

        Alert::success('Success', 'Standar pengelolaan berhasil diperbarui');
        return redirect('/standar-pengelolaan');
    }

    public function destroy($id)
    {
        $standarPengelolaan = StandarPengelolaan::findOrFail($id);
        if ($standarPengelolaan->file_path && file_exists(public_path($standarPengelolaan->file_path))) {
            unlink(public_path($standarPengelolaan->file_path));
        }
        $standarPengelolaan->delete();

        Alert::success('Success', 'Standar pengelolaan berhasil dihapus');
        return redirect('/standar-pengelolaan');
    }
}
