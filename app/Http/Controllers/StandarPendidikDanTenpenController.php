<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StandarPendidikDanTenpen;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

class StandarPendidikDanTenpenController extends Controller
{
    public function index()
    {
        $standarPendidikan = StandarPendidikDanTenpen::with('user')->get();
        return view('pageadmin.standarpendidikdantenpen.index', compact('standarPendidikan'));
    }
    

    public function create()
    {
        return view('pageadmin.standarpendidikdantenpen.create');
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
            $file->move(public_path('standarpendidikdantenpen'), $fileName);
            $filePath = 'standarpendidikdantenpen/' . $fileName;
        }

        StandarPendidikDanTenpen::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_path' => $filePath,
            'user_id' => Auth::id(), // Menyimpan user_id dari user yang sedang login
        ]);

        Alert::success('Success', 'Standar Pendidik dan Tenaga Pendidikan berhasil ditambahkan');
        return redirect('/standar-pendidikan');
    }

    public function edit($id)
    {
        $standarPendidikan = StandarPendidikDanTenpen::findOrFail($id);
        return view('pageadmin.standarpendidikdantenpen.edit', compact('standarPendidikan'));
    }

    public function update(Request $request, $id)
    {
        $standarPendidikan = StandarPendidikDanTenpen::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $filePath = $standarPendidikan->file_path;
        if ($request->hasFile('file')) {
            if ($filePath && file_exists(public_path($filePath))) {
                unlink(public_path($filePath));
            }
            $file = $request->file('file');
            $fileName = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('standarpendidikdantenpen'), $fileName);
            $filePath = 'standarpendidikdantenpen/' . $fileName;
        }

        $standarPendidikan->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_path' => $filePath,
            'user_id' => Auth::id(), // Menyimpan user_id dari user yang sedang login
        ]);

        Alert::success('Success', 'Standar Pendidik dan Tenaga Pendidikan berhasil diperbarui');
        return redirect('/standar-pendidikan');
    }

    public function destroy($id)
    {
        $standarPendidikan = StandarPendidikDanTenpen::findOrFail($id);
        if ($standarPendidikan->file_path && file_exists(public_path($standarPendidikan->file_path))) {
            unlink(public_path($standarPendidikan->file_path));
        }
        $standarPendidikan->delete();

        Alert::success('Success', 'Standar Pendidik dan Tenaga Pendidikan berhasil dihapus');
        return redirect('/standar-pendidikan');
    }
}
