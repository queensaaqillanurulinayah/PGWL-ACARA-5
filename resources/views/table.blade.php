@extends('layouts.template')

@section('styles')

<style>
    html, body {
        height: 100%;
        margin: 0;
    }

</style>
@endsection

@section('content')
    <div class="container mt-3">

        <div class="card">
            <div class="card-header">
                <h3>Tabel Data</h3>
            </div>
            <div class="card-body">
                <table class="table table bordered table-striped">
                    <head>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                        </tr>
                    </head>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Bundaran UGM</td>
                            <td>Jalan Pancasila</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Tugu Yogyakarta</td>
                            <td>Landmark ikonik Kota Yogyakarta</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Malioboro</td>
                            <td>Kawasan wisata dan pusat perbelanjaan terkenal</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Keraton Yogyakarta</td>
                            <td>Istana resmi Kesultanan Yogyakarta</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Alun-Alun Kidul</td>
                            <td>Ruang publik dengan tradisi masangin</td>
                        </tr>
                    </tbody>
                </table>
            </div>
    </div>
    </div>
@endsection
