@extends('layouts.template')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.8/css/dataTables.dataTables.css">
<style>
    html,
    body {
        height: 100%;
        margin: 0;
        background-color: #f4f6f9;
        font-family: 'Segoe UI', sans-serif;
    }

    .container {
        max-width: 1000px;
    }

    /* CARD */
    .card {
        border: none;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    }

    .card-header {
        background: linear-gradient(90deg, #0d6efd, #0a58ca);
        color: white;
        padding: 18px 24px;
        border-bottom: none;
    }

    .card-header h3 {
        margin: 0;
        font-weight: 600;
    }

    .card-body {
        background: white;
        padding: 25px;
    }

    /* TABLE */
    .table {
        margin-bottom: 0;
        border-radius: 12px;
        overflow: hidden;
    }

    .table thead {
        background-color: #0d6efd;
        color: white;
    }

    .table thead th {
        border: none;
        padding: 14px;
        text-align: center;
        font-weight: 600;
    }

    .table tbody td {
        padding: 14px;
        vertical-align: middle;
        border-color: #e9ecef;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f8f9fa;
    }

    .table tbody tr:hover {
        background-color: #eaf3ff;
        transition: 0.3s;
    }

    /* NOMOR TENGAH */
    .table tbody td:first-child {
        text-align: center;
        font-weight: 500;
    }
</style>
@endsection

@section('content')
    <div class="container mt-3">

        <div class="card">
            <div class="card-header">
                <h3>Tabel Data Titik</h3>
            </div>
            <div class="card-body">
                <table class="table table bordered table-striped" id="tabledatapoints">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Foto</th>
                            <th>Tanggal Dibuat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($points as $p)
                        <tr>
                            <td>{{ $p['id'] }}</td>
                            <td>{{ $p['nama'] }}</td>
                            <td>{{ $p['description'] }}</td>
                            <td>
                                <img src="{{ asset('storage/images') . '/'. $p['image'] }}" alt=""
                                width="100">
                            </td>
                            <td>{{ $p['created_at'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h3>Tabel Data Garis</h3>
            </div>
            <div class="card-body">
                <table class="table table bordered table-striped" id="tabledatapolylines">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Foto</th>
                            <th>Tanggal Dibuat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($polylines as $p)
                        <tr>
                            <td>{{ $p['id'] }}</td>
                            <td>{{ $p['nama'] }}</td>
                            <td>{{ $p['description'] }}</td>
                            <td>
                                <img src="{{ asset('storage/images') . '/'. $p['image'] }}" alt=""
                                width="100">
                            </td>
                            <td>{{ $p['created_at'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h3>Tabel Data Area</h3>
            </div>
            <div class="card-body">
                <table class="table table bordered table-striped" id="tabledatapolygons">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Foto</th>
                            <th>Tanggal Dibuat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($polygons as $p)
                        <tr>
                            <td>{{ $p['id'] }}</td>
                            <td>{{ $p['nama'] }}</td>
                            <td>{{ $p['description'] }}</td>
                            <td>
                                <img src="{{ asset('storage/images') . '/'. $p['image'] }}" alt=""
                                width="100">
                            </td>
                            <td>{{ $p['created_at'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src ="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src ="https://cdn.datatables.net/2.3.8/js/dataTables.js"></script>
<script>
    new DataTable('#tabledatapoints');
    new DataTable('#tabledatapolylines');
    new DataTable('#tabledatapolygons');
</script>
@endsection
