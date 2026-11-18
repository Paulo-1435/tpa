<?php

use App\Http\Controllers\EventoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PedidoController;
use Illuminate\Support\Facades\Route;

// Páginas de ilustração (prontas)
Route::view('/', 'home')->name('home');
Route::view('/sobre', 'sobre')->name('sobre');

// Autenticação
Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'attempt'])->name('login.attempt');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Eventos
Route::get('/eventos', [EventoController::class, 'index'])->name('eventos.index');

Route::middleware(['auth', 'organizador'])->group(function () {
    Route::get('/eventos/create', [EventoController::class, 'create'])->name('eventos.create');
    Route::post('/eventos', [EventoController::class, 'store'])->name('eventos.store');
});

// Pedidos
Route::middleware('auth')->group(function () {
    Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
    Route::get('/pedidos/create', [PedidoController::class, 'create'])->name('pedidos.create');
    Route::post('/pedidos', [PedidoController::class, 'store'])->name('pedidos.store');
});
