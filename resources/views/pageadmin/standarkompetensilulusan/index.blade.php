@extends('template-admin.layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dokumen /</span> Standar Kompetensi Lulusan</h4>

        <div class="mb-3">
            <a href="/standar-kompetensi-lulusan/create" class="btn btn-sm btn-primary">
                <i class='bx bx-plus'></i> Tambah Standar Kompetensi Lulusan
            </a>
        </div>

        <div class="row">
            @foreach($standarKompetensi as $standarKompetensi)
                <div class="col-md-3 mb-3">
                    <div class="card h-100 bg-dark text-light">
                        <div class="card-body d-flex flex-column align-items-center">
                            <div class="box-icon mb-3">
                                <i class='bx bxs-file-doc' style="font-size: 50px;"></i>
                            </div>
                            <div class=" flex-grow-1">
                                <p class="card-text"><small class="text-muted">Pengupload: {{ $standarKompetensi->user->nama }}</small></p>
                                <h5 class="card-title text-light">{{ $standarKompetensi->judul }}</h5>
                                <p class="card-text">{{ $standarKompetensi->deskripsi }}</p>
                            </div>
                            <div class="d-flex justify-content-center mt-3">
                                @if($standarKompetensi->file_path)
                                    <a href="{{ asset($standarKompetensi->file_path) }}" class="btn btn-primary btn-sm me-2" target="_blank">
                                        <i class='bx bx-download'></i> UNDUH
                                    </a>
                                @endif
                                <a href="/standar-kompetensi-lulusan/{{ $standarKompetensi->id }}/edit" class="btn btn-warning btn-sm me-2">
                                    <i class='bx bx-edit'></i> Edit
                                </a>
                                <form action="/standar-kompetensi-lulusan/{{ $standarKompetensi->id }}" method="POST" class="d-inline">
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