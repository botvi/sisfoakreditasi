<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StandarPenilaian;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

class StandarPenilaianController extends Controller
{
    public function index()
    {
        $user = Auth::user();
    
        if ($user->role == 'guru') {
            // Untuk role 'guru', hanya menampilkan data yang ditambahkan oleh guru tersebut
            $StandarPenilaian = StandarPenilaian::where('user_id', $user->id)->get();
        } else {
            // Untuk role 'kepalasekolah' dan 'admin', menampilkan semua data
            $StandarPenilaian = StandarPenilaian::all();
        }
        return view('pageadmin.standarpenilaian.index', compact('StandarPenilaian'));
    }
    

    public function create()
    {
        return view('pageadmin.standarpenilaian.create');
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
            $file->move(public_path('standarpenilaian'), $fileName);
            $filePath = 'standarpenilaian/' . $fileName;
        }

        StandarPenilaian::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_path' => $filePath,
            'user_id' => Auth::id(), // Menyimpan user_id dari user yang sedang login
        ]);

        Alert::success('Success', 'Standar penilaian berhasil ditambahkan');
        return redirect('/standar-penilaian');
    }

    public function edit($id)
    {
        $StandarPenilaian = StandarPenilaian::findOrFail($id);
        return view('pageadmin.standarpenilaian.edit', compact('StandarPenilaian'));
    }

    public function update(Request $request, $id)
    {
        $StandarPenilaian = StandarPenilaian::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $filePath = $StandarPenilaian->file_path;
        if ($request->hasFile('file')) {
            if ($filePath && file_exists(public_path($filePath))) {
                unlink(public_path($filePath));
            }
            $file = $request->file('file');
            $fileName = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('standarpenilaian'), $fileName);
            $filePath = 'standarpenilaian/' . $fileName;
        }

        $StandarPenilaian->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_path' => $filePath,
            'user_id' => Auth::id(), // Menyimpan user_id dari user yang sedang login
        ]);

        Alert::success('Success', 'Standar penilaian berhasil diperbarui');
        return redirect('/standar-penilaian');
    }

    public function destroy($id)
    {
        $StandarPenilaian = StandarPenilaian::findOrFail($id);
        if ($StandarPenilaian->file_path && file_exists(public_path($StandarPenilaian->file_path))) {
            unlink(public_path($StandarPenilaian->file_path));
        }
        $StandarPenilaian->delete();

        Alert::success('Success', 'Standar penilaian berhasil dihapus');
        return redirect('/standar-penilaian');
    }
}
