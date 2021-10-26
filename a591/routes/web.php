<?php

namespace App\Http\Controllers;

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
    return view('welcome');
});

Route::get('/591', function () {
    return view('591');
});

Route::get('/login', function () {
    return view('login');
});

Route::post('/send', function () {
    return view('send');
});

Route::get('/get591',[get591Controller::class,'get591']);
// Route::get('/get591', 'App\Http\Controllers\get591Controller@get591');


Route::get('/test', [indexController::class, 'test']);


Route::get('/index', [indexController::class, 'index']);
Route::post('/index',[indexController::class,'index']);


Route::get('/admin/product/new', 'App\Http\Controllers\ProductController@newProduct');
Route::get('/admin/products', 'App\Http\Controllers\ProductController@index');
Route::get('/admin/product/destroy/{id}', 'App\Http\Controllers\ProductController@destroy');
Route::post('/admin/product/save', 'App\Http\Controllers\ProductController@add');
Route::get('/', 'App\Http\Controllers\MainController@index');
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');