@extends('template-admin.layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dokumen /</span> Standar Pendidik & Tenaga Pendidikan</h4>

        <div class="mb-3">
            <a href="/standar-pendidikan/create" class="btn btn-sm btn-primary">
                <i class='bx bx-plus'></i> Tambah Standar Pendidik & Tenaga Pendidikan
            </a>
        </div>

        <div class="row">
            @foreach($standarPendidikan as $standarPendidikan)
            @php
            $bgColor = '#343a40'; // Default dark background
            $fileExtension = pathinfo($standarPendidikan->file_path, PATHINFO_EXTENSION);

            if ($fileExtension === 'pdf') {
                $bgColor = '#dc3545'; // Red for PDF
            } elseif ($fileExtension === 'docx') {
                $bgColor = '#007bff'; // Blue for DOCX
            } elseif ($fileExtension === 'xlsx') {
                $bgColor = '#28a745'; // Green for XLSX
            }
        @endphp

        <div class="col-md-3 mb-3">
            <div class="card h-100" style="background-color: {{ $bgColor }}; color: #fff;">
                        <div class="card-body d-flex flex-column align-items-center">
                            <div class="box-icon mb-3">
                                <i class='bx bxs-file-doc' style="font-size: 50px;"></i>
                            </div>
                            <div class=" flex-grow-1">
                                <p class="card-text"><small class="text-muted">Pengupload: {{ $standarPendidikan->user->nama }}</small></p>
                                <h5 class="card-title text-light">{{ $standarPendidikan->judul }}</h5>
                                <p class="card-text">{{ $standarPendidikan->deskripsi }}</p>
                                <h6 class="card-text text-white">Waktu Upload: {{ \Carbon\Carbon::parse($standarPendidikan->created_at)->format('d F Y') }}</h6>

                            </div>
                            <div class="d-flex justify-content-center mt-3">
                                @if($standarPendidikan->file_path)
                                    <a href="{{ asset($standarPendidikan->file_path) }}" class="btn btn-primary btn-sm me-2" target="_blank">
                                        <i class='bx bx-download'></i> UNDUH
                                    </a>
                                @endif
                                <a href="/standar-pendidikan/{{ $standarPendidikan->id }}/edit" class="btn btn-warning btn-sm me-2">
                                    <i class='bx bx-edit'></i> Edit
                                </a>
                                <form action="/standar-pendidikan/{{ $standarPendidikan->id }}" method="POST" class="d-inline">
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
