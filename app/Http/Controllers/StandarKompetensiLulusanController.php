<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StandarKompetensiLulusan;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

class StandarKompetensiLulusanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
    
        if ($user->role == 'guru') {
            // Untuk role 'guru', hanya menampilkan data yang ditambahkan oleh guru tersebut
            $standarKompetensi = StandarKompetensiLulusan::where('user_id', $user->id)->get();
        } else {
            // Untuk role 'kepalasekolah' dan 'admin', menampilkan semua data
            $standarKompetensi = StandarKompetensiLulusan::all();
        }
        return view('pageadmin.standarkompetensilulusan.index', compact('standarKompetensi'));
    }
    

    public function create()
    {
        return view('pageadmin.standarkompetensilulusan.create');
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
            $file->move(public_path('standarkompetensilulusan'), $fileName);
            $filePath = 'standarkompetensilulusan/' . $fileName;
        }

        StandarKompetensiLulusan::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_path' => $filePath,
            'user_id' => Auth::id(), // Menyimpan user_id dari user yang sedang login
        ]);

        Alert::success('Success', 'Standar Kompetensi Lulusan berhasil ditambahkan');
        return redirect('/standar-kompetensi-lulusan');
    }

    public function edit($id)
    {
        $standarKompetensi = StandarKompetensiLulusan::findOrFail($id);
        return view('pageadmin.standarkompetensilulusan.edit', compact('standarKompetensi'));
    }

    public function update(Request $request, $id)
    {
        $standarKompetensi = StandarKompetensiLulusan::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $filePath = $standarKompetensi->file_path;
        if ($request->hasFile('file')) {
            if ($filePath && file_exists(public_path($filePath))) {
                unlink(public_path($filePath));
            }
            $file = $request->file('file');
            $fileName = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('standarKompetensi'), $fileName);
            $filePath = 'standarKompetensi/' . $fileName;
        }

        $standarKompetensi->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_path' => $filePath,
            'user_id' => Auth::id(), // Menyimpan user_id dari user yang sedang login
        ]);

        Alert::success('Success', 'Standar Kompetensi Lulusan berhasil diperbarui');
        return redirect('/standar-kompetensi-lulusan');
    }

    public function destroy($id)
    {
        $standarKompetensi = StandarKompetensiLulusan::findOrFail($id);
        if ($standarKompetensi->file_path && file_exists(public_path($standarKompetensi->file_path))) {
            unlink(public_path($standarKompetensi->file_path));
        }
        $standarKompetensi->delete();

        Alert::success('Success', 'Standar Kompetensi Lulusa berhasil dihapus');
        return redirect('/standar-kompetensi-lulusan');
    }
}
