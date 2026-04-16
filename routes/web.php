<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\SocialiteController;



Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('locations', LocationController::class)->except(['index', 'show', 'create'])->middleware('admin_or_owner_location');
Route::resource('locations', LocationController::class)->only(['index', 'show', 'create']);

Route::resource('films', FilmController::class)->except(['index', 'show'])->middleware('admin');
Route::resource('films', FilmController::class)->only(['index', 'show']);

Route::post('/locations/upvote', [LocationController::class, 'upvote'])->middleware('auth')->name('locations.upvote');

Route::get('/auth/github/redirect', [SocialiteController::class, 'redirect']);
Route::get('/auth/github/callback', [SocialiteController::class, 'callback']);

require __DIR__ . '/auth.php';
