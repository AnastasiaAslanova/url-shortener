<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/auth/redirect/github', function () {
    return Socialite::driver('github')->redirect();
});

Route::get('/auth/github', [\App\Http\Controllers\Auth\AuthGithub::class, 'callback']);
Route::get('/url/generator',[\App\Http\Controllers\ShortUrlGenerator::class, 'index'])->name('urlGenerator');
Route::get('/{short}',[\App\Http\Controllers\ShortUrlGenerator::class, 'short'])->name('short');
