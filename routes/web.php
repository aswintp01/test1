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
use App\Http\Controllers\HobbiesController;

Route::get('/', [HobbiesController::class, 'index']);
Route::post('/save-hobbies', [HobbiesController::class, 'create']);
Route::get('/hobbies', [HobbiesController::class, 'hobbies']);
Route::get('/update/{user_id}', [HobbiesController::class, 'update']);
Route::post('/update', [HobbiesController::class, 'updatePost']);
Route::get('/delete/{user_id}', [HobbiesController::class, 'delete']);
