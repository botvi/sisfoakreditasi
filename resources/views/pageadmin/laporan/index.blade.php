@extends('template-admin.layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Laporan /</span> Semua Standar</h4>

        <div class="mb-3">
            <form action="{{ url('/laporan') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <select name="user_id" class="form-control">
                        <option value="">Pilih Pengupload</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $user_id == $user->id ? 'selected' : '' }}>
                                {{ $user->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="model_name" class="form-control">
                        <option value="">Pilih Model</option>
                        @foreach($models as $name => $model)
                            <option value="{{ $name }}" {{ $model_name == $name ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
                <div class="col-md-3">
                    <button type="button" onclick="printTable()" class="btn btn-secondary">Print</button>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered">
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
        </div>
    </div>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .table, .table * {
                visibility: visible;
            }
            .table {
                position: absolute;
                left: 0;
                top: 0;
            }
        }
    </style>

    <script>
        function printTable() {
            window.print();
        }
    </script>
@endsection
