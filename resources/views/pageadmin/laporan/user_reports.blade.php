<!-- resources/views/pageadmin/laporan/user_reports.blade.php -->
@extends('template-admin.layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dokumen /</span> Laporan Saya</h4>
        <div class="card">
            <div class="card-body">
                <!-- Tombol Print di atas tabel -->
                <div class="mb-3">
                    <button class="btn btn-primary" onclick="printTable()">Print</button>
                </div>
                <table id="reportTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Deskripsi</th>
                            <th>Pengupload</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reports as $report)
                            <tr>
                                <td>{{ $report->judul }}</td>
                                <td>{{ $report->deskripsi }}</td>
                                <td>{{ $report->user->nama }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Tombol Print di bawah tabel -->
               
            </div>
        </div>
    </div>

    <!-- Script untuk mencetak tabel -->
    <script>
        function printTable() {
            var printContents = document.getElementById('reportTable').outerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>
@endsection
