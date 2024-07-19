<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StandarProses;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

class StandarProsesController extends Controller
{
    public function index()
    {
        $StandarProses = StandarProses::with('user')->get();
        return view('pageadmin.standarproses.index', compact('StandarProses'));
    }
    

    public function create()
    {
        return view('pageadmin.standarproses.create');
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
            $file->move(public_path('standarproses'), $fileName);
            $filePath = 'standarproses/' . $fileName;
        }

        StandarProses::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_path' => $filePath,
            'user_id' => Auth::id(), // Menyimpan user_id dari user yang sedang login
        ]);

        Alert::success('Success', 'Standar proses berhasil ditambahkan');
        return redirect('/standar-proses');
    }

    public function edit($id)
    {
        $StandarProses = StandarProses::findOrFail($id);
        return view('pageadmin.standarproses.edit', compact('StandarProses'));
    }

    public function update(Request $request, $id)
    {
        $StandarProses = StandarProses::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $filePath = $StandarProses->file_path;
        if ($request->hasFile('file')) {
            if ($filePath && file_exists(public_path($filePath))) {
                unlink(public_path($filePath));
            }
            $file = $request->file('file');
            $fileName = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('standarproses'), $fileName);
            $filePath = 'standarproses/' . $fileName;
        }

        $StandarProses->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_path' => $filePath,
            'user_id' => Auth::id(), // Menyimpan user_id dari user yang sedang login
        ]);

        Alert::success('Success', 'Standar proses berhasil diperbarui');
        return redirect('/standar-proses');
    }

    public function destroy($id)
    {
        $StandarProses = StandarProses::findOrFail($id);
        if ($StandarProses->file_path && file_exists(public_path($StandarProses->file_path))) {
            unlink(public_path($StandarProses->file_path));
        }
        $StandarProses->delete();

        Alert::success('Success', 'Standar proses berhasil dihapus');
        return redirect('/standar-proses');
    }
}
