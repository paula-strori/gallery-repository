<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/**
 * Profile
 */
Route::get('/profile/{userId}', [App\Http\Controllers\ProfileController::class, 'show'])->middleware('auth');
Route::get('/profile/{userId}/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->middleware('auth');
Route::post('/profile/{userId}/update', [App\Http\Controllers\ProfileController::class, 'update'])->middleware('auth')->name('user-update');
Route::post('/profile/{userId}/addPhoto', [App\Http\Controllers\ProfileController::class, 'addPhoto'])->middleware('auth')->name('user-add-photo');
Route::post('/profile/{userId}/myPhotos', [App\Http\Controllers\ProfileController::class, 'myPhotos'])->middleware('auth');

/**
 * Photos
 */
Route::get('/photos', [\App\Http\Controllers\PhotoController::class, 'index']);
Route::get('/photos/{photoId}/download', [\App\Http\Controllers\PhotoController::class, 'downloadPhoto'])->name('photo-download');
Route::post('/photos/{photoId}/bookmark', [\App\Http\Controllers\PhotoController::class, 'bookmarkPhoto']);
