<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\PointsController;
use App\Http\Controllers\PolygonsController;
use App\Http\Controllers\PolylinesController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'landingpage'])->name('home');

Route::get('/peta', [PageController::class, 'peta'])
->middleware(['auth', 'verified'])
->name('peta');

Route::get('/tabel', [PageController::class, 'tabel'])->name('tabel');

Route::post('/store-points', [PointsController::class, 'store'])->name('points.store');

Route::delete('/delete-points/{id}', [PointsController::class, 'destroy'])->name('points.delete');

Route::get('/edit-point/{id}', [PointsController::class, 'edit'])->name('point.edit');

Route::patch('/update-point/{id}', [PointsController::class, 'update'])->name('point.update');

Route::post('/store-polylines', [PolylinesController::class, 'store'])->name('polylines.store');

Route::delete('/delete-polylines/{id}', [PolylinesController::class, 'destroy'])->name('polylines.delete');

Route::get('/edit-polyline/{id}', [PolylinesController::class, 'edit'])->name('polyline.edit');

Route::patch('/update-polyline/{id}', [PolylinesController::class, 'update'])->name('polyline.update');

Route::post('/store-polygons', [PolygonsController::class, 'store'])->name('polygons.store');

Route::delete('/store-polygons/{id}', [PolygonsController::class, 'destroy'])->name('polygons.delete');

Route::get('/edit-polygon/{id}', [PolygonsController::class, 'edit'])->name('polygon.edit');

Route::patch('/update-polygon/{id}', [PolygonsController::class, 'update'])->name('polygon.update');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

require __DIR__.'/settings.php';
