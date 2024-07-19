@extends('template-admin.layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms /</span> Edit Standar Sarana & Prasarana</h4>

        <div class="card">
            <h5 class="card-header">Edit Standar Sarana & Prasarana</h5>
            <div class="card-body">
                <form action="/standar-sarana/{{ $StandarSaranaDanPra->id }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul</label>
                        <input type="text" class="form-control" id="judul" name="judul" value="{{ $StandarSaranaDanPra->judul }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required>{{ $StandarSaranaDanPra->deskripsi }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="file" class="form-label">File</label>
                        <input class="form-control" type="file" id="file" name="file">
                        @if($StandarSaranaDanPra->file_path)
                            <a href="{{ asset($StandarSaranaDanPra->file_path) }}" target="_blank">Lihat File Saat Ini</a>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection
