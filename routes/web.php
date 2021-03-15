<?php

use App\Http\Livewire\Citas;
use App\Http\Livewire\Informes;
use App\Http\Livewire\Mascotas;
use App\Http\Livewire\Productos;
use App\Http\Livewire\Usuarios;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/index', function () {
    return view('index');
})->name('index');

Route::middleware(['auth:sanctum', 'verified'])->get('/contacto', function () {
    return view('contacto');
})->name('contacto');

Route::middleware(['auth:sanctum', 'verified', 'checkRol'])->group(function () {
    Route::get('/usuarios', Usuarios::class)->name('usuarios');
    Route::get('/mascotas', Mascotas::class)->name('mascotas');
    Route::get('/informes', Informes::class)->name('informes');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/productos', Productos::class)->name('productos');
Route::middleware(['auth:sanctum', 'verified'])->get('/citas', Citas::class)->name('citas');
