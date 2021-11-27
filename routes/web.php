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
})->name('home');

require __DIR__.'/auth.php';

Route::get('/auth/redirect/github', function () {
    return Socialite::driver('github')->redirect();
});

Route::get('/auth/github', [\App\Http\Controllers\Auth\AuthGithub::class, 'callback']);

Route::middleware(['auth'])->group(function() {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/generator/url', function (\Illuminate\Http\Request $request) {
        $type = $request->input('type');
        if (in_array($type, ['shortWithKey', 'simpleShort'])) {
            return view('generator-url', ['type' => $type]);
        } else {
            return view('namedUrl');
        }
    })->name('choice');

    Route::post('/url/generator', [\App\Http\Controllers\ShortUrlGenerator::class, 'generate'])->name('urlGenerator');
    Route::post('/url/named_generator', [\App\Http\Controllers\ShortUrlGenerator::class, 'generateNamed'])->name('namedUrlGenerator');

    Route::get('/url/list', [\App\Http\Controllers\ShortUrlGenerator::class, 'linkList'])->name('linkList');

    Route::get('/url/delete/id', [\App\Http\Controllers\DeleteUrl::class, 'delete'])->name('delete');
});

Route::get('/{short}', [\App\Http\Controllers\ShortUrlGenerator::class, 'short'])->name('short');
Route::get('/{short}/{key}', [\App\Http\Controllers\ShortUrlGenerator::class, 'shortWithKey'])->name(
    'urlGeneratorWithKey'
);


