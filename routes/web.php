<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HelloController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\BuildController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\TermsController;
use App\Http\Controllers\PrivacyController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/', [HelloController::class, 'index']);
Route::get('/home', [HomeController::class, 'index'])
    ->middleware('auth');
Route::get('/note', [NoteController::class, 'index'])
    ->middleware('auth');
Route::get('/search', [SearchController::class, 'index'])
    ->middleware('auth');
Route::get('/build', [BuildController::class, 'index'])
    ->middleware('auth');
Route::get('/help', [HelpController::class, 'index']);
Route::get('/terms', [TermsController::class, 'index']);
Route::get('/privacy', [PrivacyController::class, 'index']);
