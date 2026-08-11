<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UmkmController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/profil-desa', ProfileController::class)->name('profile');

Route::get('/kontak', [ContactController::class, 'index'])->name('contact');
Route::post('/kontak', [ContactController::class, 'store'])->middleware('throttle:5,1')->name('contact.store');

Route::get('/artikel', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/artikel/{slug}', [ArticleController::class, 'show'])->name('articles.show');

Route::get('/potensi-wisata', [DestinationController::class, 'index'])->name('destinations.index');
Route::get('/potensi-wisata/{slug}', [DestinationController::class, 'show'])->name('destinations.show');

Route::get('/umkm', [UmkmController::class, 'index'])->name('umkm');
Route::get('/umkm/{slug}', [UmkmController::class, 'show'])->name('umkm.show');