<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\customer;
use App\Http\Controllers\posts;
use App\Http\Controllers\Tags_controller;
use App\Models\tags_model;

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

Route::get('/customers', [customer::class, 'get_customer']);
Route::get('/login', [customer::class, 'login']);
Route::get('/register', [customer::class, 'register']);
Route::post('/check_login', [customer::class, 'check_login']);

Route::middleware(['webguard'])->group(function () {
    Route::get('/posts', [posts::class, 'get_posts']);
    Route::get('/create_customer', [customer::class, 'customer_form']);
    Route::post('/create_customer', [customer::class, 'add_customer']);
    Route::get('/delete_customer/{id}', [customer::class, "delete_customer"]);
    Route::get('/update_customer/{id}', [customer::class, 'update_customer_form']);
    Route::post('/update_customer/{id}', [customer::class, 'update_customer']);




    Route::get('/view_trash', [customer::class, 'view_trash']);
    Route::get('/permenent_delete_customer/{id}', [customer::class, "permenent_delete_customer"]);
    Route::get('/restore_customer/{id}', [customer::class, "restore_customer"]);

    Route::post('/get_customers', [customer::class, 'customers_dtable']);

    Route::get('/checks', [customer::class, 'test']);

    Route::get('/create_post', [posts::class, 'post_form']);
    Route::post('/add_post_data', [posts::class, 'add_post_data']);
    Route::get('/tags_search', [Tags_controller::class, 'tags_search']);


    Route::get('/user_likes/{customer_id}', [customer::class, 'get_user_likes']);
    // Route::get('/user_likes/{customer_id}',[customer::class,'get_user_likes']);
});
