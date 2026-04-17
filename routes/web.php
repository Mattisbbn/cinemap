<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\SubscriptionController;



Route::get('/', function () {
    return view('home');
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('locations', LocationController::class)->except(['index', 'show', 'create', 'store'])->middleware('admin_or_owner_location');
Route::resource('locations', LocationController::class)->only(['index', 'show', 'create', 'store']);

Route::resource('films', FilmController::class)->except(['index', 'show'])->middleware('admin');
Route::resource('films', FilmController::class)->only(['index', 'show']);

Route::post('/locations/upvote', [LocationController::class, 'upvote'])->middleware('auth')->name('locations.upvote');

Route::get('/auth/github/redirect', [SocialiteController::class, 'redirect']);
Route::get('/auth/github/callback', [SocialiteController::class, 'callback']);

Route::get('/subscription', [SubscriptionController::class, 'index'])->name('subscription.index')->middleware('auth');
Route::post('/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscription.subscribe')->middleware('auth');

require __DIR__ . '/auth.php';
