@extends('template-admin.layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Data Guru /</span> Edit</h4>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Edit Data Guru</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="/data-gurus/{{ $dataGuru->id }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="foto" class="form-label">Foto</label>
                                <input class="form-control" type="file" id="foto" name="foto">
                                @if($dataGuru->foto)
                                    <div class="mt-2">
                                        <img src="{{ asset($dataGuru->foto) }}" alt="{{ $dataGuru->nama }}" class="img-fluid rounded" style="max-width: 200px;">
                                    </div>
                                    <div class="mt-2">
                                        <a href="{{ asset($dataGuru->foto) }}" target="_blank">Lihat Foto Saat Ini</a>
                                    </div>
                                @else
                                    <div class="mt-2">
                                        <img src="https://thumbs.dreamstime.com/b/default-avatar-profile-image-vector-social-media-user-icon-potrait-182347582.jpg" alt="Default Avatar" class="img-fluid rounded" style="max-width: 200px;">
                                    </div>
                                    <div class="mt-2">
                                        <span class="text-muted">Foto belum diunggah.</span>
                                    </div>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama:</label>
                                <input type="text" id="nama" name="nama" class="form-control" value="{{ $dataGuru->nama }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="nip" class="form-label">NIP:</label>
                                <input type="text" id="nip" name="nip" class="form-control" value="{{ $dataGuru->nip }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir:</label>
                                <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control" value="{{ $dataGuru->tanggal_lahir }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat:</label>
                                <input type="text" id="alamat" name="alamat" class="form-control" value="{{ $dataGuru->alamat }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="jabatan" class="form-label">Jabatan:</label>
                                <input type="text" id="jabatan" name="jabatan" class="form-control" value="{{ $dataGuru->jabatan }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="pendidikan_terakhir" class="form-label">Pendidikan Terakhir:</label>
                                <input type="text" id="pendidikan_terakhir" name="pendidikan_terakhir" class="form-control" value="{{ $dataGuru->pendidikan_terakhir }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" id="email" name="email" class="form-control" value="{{ $dataGuru->user->email }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password (biarkan kosong jika tidak ingin mengubah):</label>
                                <input type="password" id="password" name="password" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password:</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
