<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Post_api_con;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('test', function () {
    return "helo word";
});

Route::post('test', function (Request $request) {
    return $request->all();
});
Route::post('post_create', [Post_api_con::class, 'create_post']);

Route::match(['PRIYANK'],'post_create',[Post_api_con::class, 'create_post']);
