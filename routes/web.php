<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ScreeningController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\TheaterController;
use App\Http\Controllers\EmployeeScreeningController;
use App\Http\Controllers\CustomerScreeningController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\PurchasesController;
use App\Http\Controllers\StatisticsController;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth', 'verified')->group(function () {
    Route::middleware('can:admin')->group(function () {

        Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');

        Route::get('/filmes', [MovieController::class, 'all'])->name('filmes');

        Route::delete('movies/{movie}/poster', [MovieController::class, 'destroyPoster'])->name('movies.destroyPoster');
        Route::resource('movies', MovieController::class)->except(['show']);

        Route::resource('genres', GenreController::class);

        Route::resource('theaters', TheaterController::class);

        Route::resource('screenings', ScreeningController::class)->except(['show']);

        Route::delete('employees/{employee}/photo', [EmployeeScreeningController::class, 'destroyPhoto'])->name('employees.destroyPhoto');
        Route::resource('employees', EmployeeScreeningController::class);

        Route::resource('customers', CustomerScreeningController::class);

        Route::delete('admins/{admin}/photo', [AdminController::class, 'destroyPhoto'])
        ->name('admins.destroyPhoto');

        Route::delete('admins/{admin}/poster', [AdminController::class, 'destroyPoster'])->name('admins.destroyPoster');

        Route::resource('admins', AdminController::class);

        Route::resource('tickets', TicketController::class);

        Route::resource('purchases', PurchasesController::class);

        Route::resource('configurations', PurchasesController::class);

        Route::get('/statistics/average-sales-per-movie', [StatisticsController::class, 'averageSalesPerMovie'])
    ->name('statistics.average_sales_per_movie');

    });
    Route::middleware('can:employee')->group(function () {
        Route::resource('tickets', TicketController::class)->only(['show']);
    });
});

require __DIR__.'/auth.php';

/* Rotas Originais */

Route::get('/bilhetes', [TicketController::class, 'userTickets'])->name('bilhetes');

Route::resource('screenings', ScreeningController::class)->only(['show']);

Route::resource('movies', MovieController::class)->only(['show']);

Route::view('/', 'home')->name('home');
Route::get('/', [MainController::class, 'index'])->name('home');
Route::get('/cartaz', [MovieController::class, 'cartaz'])->name('cartaz');

Route::get('/movies/search', [MovieController::class, 'search'])->name('movies.search');


// Mostrar o carrinho
Route::get('cart', [CartController::class, 'show'])->name('cart.show');

// Adicionar assentos ao carrinho
Route::post('cart', [CartController::class, 'addToCart'])->name('cart.add');
Route::delete('/cart', [CartController::class, 'destroy'])->name('cart.destroy');
Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');

Route::post('/checkout/confirm', [CheckoutController::class, 'confirm'])->name('checkout.confirm');
Route::get('/purchases/{purchase}/download-pdf', [CheckoutController::class, 'downloadPDF'])->name('download-pdf');
Route::get('/purchases/{purchase}/download-pdf', [CheckoutController::class, 'downloadPDF'])->name('download-pdf');

