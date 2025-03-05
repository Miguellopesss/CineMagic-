<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ScreeningController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\GenreController;

Route::view('/', 'home')->name('home');
Route::get('/', [MovieController::class, 'index'])->name('home');
Route::get('/cartaz', [MovieController::class, 'cartaz'])->name('cartaz');
Route::get('/filmes', [MovieController::class, 'all'])->name('filmes');
Route::get('filme/{id}', [ScreeningController::class, 'filme'])->name('filme');
Route::resource('filme', MovieController::class);
Route::get('/movies/search', [MovieController::class, 'search'])->name('movies.search');
Route::get('sessao/{id}', [ScreeningController::class, 'sessao'])->name('sessao');

// Mostrar o carrinho
Route::get('cart', [CartController::class, 'show'])->name('cart.show');

// Adicionar assentos ao carrinho
Route::post('cart', [CartController::class, 'addToCart'])->name('cart.add');

Route::resource('genres', GenreController::class);

