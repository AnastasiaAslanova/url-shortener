<?php

use App\Http\Controllers\Api\LinkController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\LinkResource;
use App\Models\ShortLink;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/links/{id}', function ($id){
    return new LinkResource(ShortLink::findOrFail($id));
});
Route::get('/links', function () {
    return LinkResource::collection(ShortLink::all());
});
Route::post('/links', [LinkController::class, 'addLink']);
Route::post('/links/named', [LinkController::class, 'addNamedLink']);
Route::delete('/links/{id}', [LinkController::class, 'deleteLink']);

