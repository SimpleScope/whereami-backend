<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/public', function (Request $request) {
    $flights = App\Models\UserChallenges::all();
    dd($flights);
});

// These endpoints require a valid access token.
Route::get('/private', function (Request $request) {
    return response()->json(["message" => "Hello from a private endpoint! You need to have a valid access token to see this."]);
})->middleware('jwt');

Route::namespace('Users')->prefix('users')->group(function () {
    Route::post('challenges', 'Challenges@startChallenge');
});
