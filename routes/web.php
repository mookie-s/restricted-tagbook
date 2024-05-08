<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HelloController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\BrokenNoteController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\StackController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\TermsController;
use App\Http\Controllers\PrivacyController;
use App\Http\Controllers\CsvExportController;

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

Route::get('/home', [HomeController::class, 'index'])->middleware('auth');
Route::get('/home/{tag}', [HomeController::class, 'show'])->middleware('auth');

Route::get('/note', [NoteController::class, 'index'])->middleware('auth');
Route::post('/note', [NoteController::class, 'store'])->middleware('auth');

Route::get('/broken-note', [BrokenNoteController::class, 'index'])->middleware('auth');
Route::post('/broken-note', [BrokenNoteController::class, 'update']);

Route::get('/search', [SearchController::class, 'index'])->middleware('auth');
// Route::post('/search', [SearchController::class, 'index'])->middleware('auth');

Route::get('/stack', [StackController::class, 'index'])->middleware('auth');
Route::post('store-tag', [StackController::class, 'store_tag']);
Route::post('/promoted-to-book', [StackController::class, 'promoted_to_book'])->middleware('auth');
Route::post('store-book', [StackController::class, 'store_book']);
Route::post('/change-confirm', [StackController::class, 'change_confirm'])->middleware('auth');
Route::post('update', [StackController::class, 'update']);
Route::post('/delete-confirm', [StackController::class, 'delete_confirm'])->middleware('auth');
Route::get('export-csv', [CsvExportController::class, 'export'])->middleware('auth');
Route::post('destroy', [StackController::class, 'destroy']);

Route::get('/help', [HelpController::class, 'index']);
Route::get('/terms', [TermsController::class, 'index']);
Route::get('/privacy', [PrivacyController::class, 'index']);
