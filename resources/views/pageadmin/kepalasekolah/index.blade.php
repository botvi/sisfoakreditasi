@extends('template-admin.layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Profil /</span> Kepala Sekolah</h4>

        @if ($kepalaSekolah->isEmpty())
        <div class="mb-5 text-center">
            <a href="/kepala-sekolah/create" class="btn btn-lg btn-primary">Tambah Data Kepala Sekolah</a>
        </div>
    @endif

        <div class="row">
            @foreach($kepalaSekolah as $ks)
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2 text-center">
                                    <img class="img-fluid rounded-circle mb-3" height="150px" width="150px"
                                        @if ($ks->foto)
                                            src="{{ asset($ks->foto) }}"
                                        @else
                                            src="https://thumbs.dreamstime.com/b/default-avatar-profile-image-vector-social-media-user-icon-potrait-182347582.jpg"
                                        @endif
                                        alt="{{ $ks->nama }}"
                                    >
                                </div>
                                <div class="col-md-10">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Nama</th>
                                            <td>{{ $ks->nama }}</td>
                                        </tr>
                                        <tr>
                                            <th>NIP</th>
                                            <td>{{ $ks->nip }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{ $ks->user->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Lahir</th>
                                            <td>{{ $ks->tanggal_lahir }}</td>
                                        </tr>
                                        <tr>
                                            <th>Alamat</th>
                                            <td>{{ $ks->alamat }}</td>
                                        </tr>
                                        <tr>
                                            <th>Pendidikan Terakhir</th>
                                            <td>{{ $ks->pendidikan_terakhir }}</td>
                                        </tr>
                                    </table>
                                    <div class="d-flex justify-content-center mt-3">
                                        <a href="/kepala-sekolah/{{ $ks->id }}/edit" class="btn btn-sm btn-warning me-2">Edit</a>
                                        <form action="/kepala-sekolah/{{ $ks->id }}" method="POST" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteForms = document.querySelectorAll('.delete-form');

            deleteForms.forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Anda tidak akan dapat mengembalikan ini!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endsection
