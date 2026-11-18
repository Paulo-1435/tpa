<?php

use App\Http\Controllers\EventoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PedidoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| GUIA – o que fazer neste arquivo (Q3 e Q4)
|--------------------------------------------------------------------------
| NÃO mude URLs nem nomes de rota (são contrato). Você só acrescenta
| middleware.
|
| Q3 – as duas rotas de cadastro de Eventos e as três de Pedidos precisam
| do middleware 'auth'. Dá para pôr ->middleware('auth') em cada rota, mas
| o mais limpo é agrupar:
|
|   Route::middleware('auth')->group(function () {
|       // rotas aqui dentro
|   });
|
| O 'auth' manda quem não está logado para a rota chamada 'login'
| (ela já existe logo abaixo).
|
| Q4 – as duas rotas de cadastro de Eventos precisam também de
| 'organizador'. Use os dois, nesta ordem: ['auth', 'organizador'].
| O 'auth' vem primeiro para que o visitante vá ao login em vez de
| receber 403.
|
| Cuidado: GET /eventos (a agenda) fica FORA de qualquer grupo: é pública.
|
| Para conferir: php artisan route:list -v  (mostra os middlewares de cada rota)
*/

// Páginas de ilustração (prontas)
Route::view('/', 'home')->name('home');
Route::view('/sobre', 'sobre')->name('sobre');

// Autenticação
Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'attempt'])->name('login.attempt');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Eventos
Route::get('/eventos', [EventoController::class, 'index'])->name('eventos.index'); // pública: não proteger
Route::get('/eventos/create', [EventoController::class, 'create'])->name('eventos.create'); // Q3 + Q4
Route::post('/eventos', [EventoController::class, 'store'])->name('eventos.store'); // Q3 + Q4

// Pedidos (Q3: as três só para usuário logado)
Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
Route::get('/pedidos/create', [PedidoController::class, 'create'])->name('pedidos.create');
Route::post('/pedidos', [PedidoController::class, 'store'])->name('pedidos.store');
