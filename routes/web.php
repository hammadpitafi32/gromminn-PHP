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


Route::any('/{any}', function () {
    return view('welcome');
})->where(['any' => '.*']);

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::group(['prefix' =>'admin' ,'middleware' => 'checkAdmin'],function(){
//     Route::get('/', 'AdminController@index');
//     // Route::get('users', 'AdminController@providerList');
//     Route::get('users/{type}', 'UserController@list');
//     Route::post('create-user', 'UserController@createOrUpdate')->name('create-user');
// });



