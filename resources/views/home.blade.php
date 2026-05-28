@extends('layouts.template')

@section('styles')
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            background: #f4f6f9;
            font-family: 'Segoe UI', sans-serif;
        }

        .container {
            max-width: 900px;
        }

        .card {
            border: none;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
            transition: 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.18);
        }

        .card-header {
            background: linear-gradient(90deg, #0d6efd, #0a58ca);
            color: white;
            padding: 20px;
            border-bottom: none;
        }

        .card-header h3 {
            margin: 0;
            font-weight: 600;
        }

        .card-body {
            padding: 25px;
            background: white;
        }

        .card-body p {
            font-size: 16px;
            line-height: 1.8;
            color: #555;
            text-align: justify;
        }
    </style>
@endsection

@section('content')
    <div class="container mt-3">

        <div class="card">
            <div class="card-header">
                <h3>Aplikasi Geospasial CRUD</h3>
            </div>
            <div class="card-body">
                <p>
                    Aplikasi ini dibuat untuk memenuhi tugas mata kuliah Praktikum Pemrograman Geospasial Web lanjut.
                    Aplikasi
                    ini menampilkan peta interaktif yang menunjukkan objek dengan geometri titik, garis, dan area yang dapat
                    ditambah, ditampilkan, diubah, dan dihapus. Aplikasi ini dikembangkan dengan menggunakan Laravel dan
                    PostgreSQL - PostGIS.
                </p>
            </div>
        </div>

        <div class="row mt-4">

        <div class="row">
            <div class="col-3">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Jumlah Point</h3>
                    </div>
                    <div class="card-body text-center">
                        <h1>
                            {{ $points_count }}
                        </h1>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Jumlah Polyline</h3>
                    </div>
                    <div class="card-body text-center">
                        <h1>
                             {{ $polylines_count }}
                        </h1>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Jumlah Polygon</h3>
                    </div>
                    <div class="card-body text-center">
                        <h1>
                             {{ $polygons_count }}
                        </h1>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Jumlah User</h3>
                    </div>
                    <div class="card-body text-center">
                        <h1>
                             {{ $users_count }}
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
