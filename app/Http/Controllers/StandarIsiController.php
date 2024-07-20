<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StandarIsi;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

class StandarIsiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
    
        if ($user->role == 'guru') {
            // Untuk role 'guru', hanya menampilkan data yang ditambahkan oleh guru tersebut
            $standarIsis = StandarIsi::where('user_id', $user->id)->get();
        } else {
            // Untuk role 'kepalasekolah' dan 'admin', menampilkan semua data
            $standarIsis = StandarIsi::all();
        }
        return view('pageadmin.standarisi.index', compact('standarIsis'));
    }
    

    public function create()
    {
        return view('pageadmin.standarisi.create');
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
            $file->move(public_path('standarisi'), $fileName);
            $filePath = 'standarisi/' . $fileName;
        }

        StandarIsi::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_path' => $filePath,
            'user_id' => Auth::id(), // Menyimpan user_id dari user yang sedang login
        ]);

        Alert::success('Success', 'Standar Isi berhasil ditambahkan');
        return redirect('/standar-isis');
    }

    public function edit($id)
    {
        $standarIsi = StandarIsi::findOrFail($id);
        return view('pageadmin.standarisi.edit', compact('standarIsi'));
    }

    public function update(Request $request, $id)
    {
        $standarIsi = StandarIsi::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $filePath = $standarIsi->file_path;
        if ($request->hasFile('file')) {
            if ($filePath && file_exists(public_path($filePath))) {
                unlink(public_path($filePath));
            }
            $file = $request->file('file');
            $fileName = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('standarisi'), $fileName);
            $filePath = 'standarisi/' . $fileName;
        }

        $standarIsi->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_path' => $filePath,
            'user_id' => Auth::id(), // Menyimpan user_id dari user yang sedang login
        ]);

        Alert::success('Success', 'Standar Isi berhasil diperbarui');
        return redirect('/standar-isis');
    }

    public function destroy($id)
    {
        $standarIsi = StandarIsi::findOrFail($id);
        if ($standarIsi->file_path && file_exists(public_path($standarIsi->file_path))) {
            unlink(public_path($standarIsi->file_path));
        }
        $standarIsi->delete();

        Alert::success('Success', 'Standar Isi berhasil dihapus');
        return redirect('/standar-isis');
    }
}
