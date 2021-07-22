<?php

use App\Http\Controllers\RepliesController;
use App\Http\Controllers\ThreadsController;
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

Auth::routes();


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home');

Route::get('threads/{channel:slug}/{thread}', [ThreadsController::class, 'show']);

Route::resource('threads', ThreadsController::class)
    ->except('show');

Route::get('threads/{channel:slug}', [ThreadsController::class, 'index']);

Route::post('threads/{channel:slug}/{thread}/replies', [RepliesController::class, 'store'])
    ->middleware('auth');

