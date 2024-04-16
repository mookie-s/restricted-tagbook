<?php

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

Route::get('/', [HelloController::class, 'index']);
Route::get('/home', [HomeController::class, 'index']);
Route::get('/note', [NoteController::class, 'index']);
Route::get('/search', [SearchController::class, 'index']);
Route::get('/build', [BuildController::class, 'index']);
Route::get('/help', [HelpController::class, 'index']);
Route::get('/terms', [TermsController::class, 'index']);
Route::get('/privacy', [PrivacyController::class, 'index']);