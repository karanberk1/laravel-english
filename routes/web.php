<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AnasayfaController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthController::class, 'loginPage']);
Route::get('/anasayfa', [AnasayfaController::class, 'index'])->middleware('authenticate');;
Route::get('/logout', [AuthController::class, 'logoutPage'])->middleware('authenticate');;
Route::get('/register', [AuthController::class, 'registerPage']);
Route::post('/registerPost', [AuthController::class, 'registerPost']);
Route::post('/loginPost', [AuthController::class, 'loginPost']);
