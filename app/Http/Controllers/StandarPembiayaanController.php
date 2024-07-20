<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StandarPembiayaan;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

class StandarPembiayaanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
    
        if ($user->role == 'guru') {
            // Untuk role 'guru', hanya menampilkan data yang ditambahkan oleh guru tersebut
            $standarPembiyaan = StandarPembiayaan::where('user_id', $user->id)->get();
        } else {
            // Untuk role 'kepalasekolah' dan 'admin', menampilkan semua data
            $standarPembiyaan = StandarPembiayaan::all();
        }
        return view('pageadmin.standarpembiayaan.index', compact('standarPembiyaan'));
    }
    

    public function create()
    {
        return view('pageadmin.standarpembiayaan.create');
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
            $file->move(public_path('standarpembiayaan'), $fileName);
            $filePath = 'standarpembiayaan/' . $fileName;
        }

        StandarPembiayaan::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_path' => $filePath,
            'user_id' => Auth::id(), // Menyimpan user_id dari user yang sedang login
        ]);

        Alert::success('Success', 'Standar Pembiayaan berhasil ditambahkan');
        return redirect('/standar-pembiayaan');
    }

    public function edit($id)
    {
        $standarPembiyaan = StandarPembiayaan::findOrFail($id);
        return view('pageadmin.standarpembiayaan.edit', compact('standarPembiyaan'));
    }

    public function update(Request $request, $id)
    {
        $standarPembiyaan = StandarPembiayaan::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $filePath = $standarPembiyaan->file_path;
        if ($request->hasFile('file')) {
            if ($filePath && file_exists(public_path($filePath))) {
                unlink(public_path($filePath));
            }
            $file = $request->file('file');
            $fileName = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('standarpembiayaan'), $fileName);
            $filePath = 'standarpembiayaan/' . $fileName;
        }

        $standarPembiyaan->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_path' => $filePath,
            'user_id' => Auth::id(), // Menyimpan user_id dari user yang sedang login
        ]);

        Alert::success('Success', 'Standar Pembiayaan berhasil diperbarui');
        return redirect('/standar-pembiayaan');
    }

    public function destroy($id)
    {
        $standarPembiyaan = StandarPembiayaan::findOrFail($id);
        if ($standarPembiyaan->file_path && file_exists(public_path($standarPembiyaan->file_path))) {
            unlink(public_path($standarPembiyaan->file_path));
        }
        $standarPembiyaan->delete();

        Alert::success('Success', 'Standar Pembiayaan berhasil dihapus');
        return redirect('/standar-pembiayaan');
    }
}
