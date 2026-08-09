<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/a-propos', [PageController::class, 'about'])->name('about');

Route::prefix('services')->name('services.')->group(function () {
    Route::get('/', [ServiceController::class, 'index'])->name('index');
    Route::get('/conseil-strategie', [ServiceController::class, 'conseil'])->name('conseil');
    Route::get('/communication-publicite', [ServiceController::class, 'communication'])->name('communication');
    Route::get('/marketing-digital', [ServiceController::class, 'marketing'])->name('marketing');
    Route::get('/solutions-numeriques', [ServiceController::class, 'solutions'])->name('solutions');
    Route::get('/ilepay', [ServiceController::class, 'ilepay'])->name('ilepay');
});

Route::prefix('realisations')->name('portfolio.')->group(function () {
    Route::get('/', [PortfolioController::class, 'index'])->name('index');
    Route::get('/{project:slug}', [PortfolioController::class, 'show'])->name('show');
});

Route::prefix('insights')->name('blog.')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('index');
    Route::get('/{article:slug}', [BlogController::class, 'show'])->name('show');
});

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('contact.store');
