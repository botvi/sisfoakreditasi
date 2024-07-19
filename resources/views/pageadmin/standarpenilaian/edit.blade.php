@extends('template-admin.layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms /</span> Edit Standar Penilaian</h4>

        <div class="card">
            <h5 class="card-header">Edit Standar Penilaian</h5>
            <div class="card-body">
                <form action="/standar-penilaian/{{ $StandarPenilaian->id }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul</label>
                        <input type="text" class="form-control" id="judul" name="judul" value="{{ $StandarPenilaian->judul }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required>{{ $StandarPenilaian->deskripsi }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="file" class="form-label">File</label>
                        <input class="form-control" type="file" id="file" name="file">
                        @if($StandarPenilaian->file_path)
                            <a href="{{ asset($StandarPenilaian->file_path) }}" target="_blank">Lihat File Saat Ini</a>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection
