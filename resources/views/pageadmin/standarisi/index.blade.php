@extends('template-admin.layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dokumen /</span> Standar Isi</h4>

        <div class="mb-3">
            <a href="/standar-isis/create" class="btn btn-sm btn-primary">
                <i class='bx bx-plus'></i> Tambah Standar Isi
            </a>
        </div>

        <div class="row">
            @foreach($standarIsis as $standarIsi)
                <div class="col-md-3 mb-3">
                    <div class="card h-100 bg-dark text-light">
                        <div class="card-body d-flex flex-column align-items-center">
                            <div class="box-icon mb-3">
                                <i class='bx bxs-file-doc' style="font-size: 50px;"></i>
                            </div>
                            <div class=" flex-grow-1">
                                <p class="card-text"><small class="text-muted">Pengupload: {{ $standarIsi->user->nama }}</small></p>
                                <h5 class="card-title text-light">{{ $standarIsi->judul }}</h5>
                                <p class="card-text">{{ $standarIsi->deskripsi }}</p>
                            </div>
                            <div class="d-flex justify-content-center mt-3">
                                @if($standarIsi->file_path)
                                    <a href="{{ asset($standarIsi->file_path) }}" class="btn btn-primary btn-sm me-2" target="_blank">
                                        <i class='bx bx-download'></i> UNDUH
                                    </a>
                                @endif
                                <a href="/standar-isis/{{ $standarIsi->id }}/edit" class="btn btn-warning btn-sm me-2">
                                    <i class='bx bx-edit'></i> Edit
                                </a>
                                <form action="/standar-isis/{{ $standarIsi->id }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">
                                        <i class='bx bx-trash'></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
