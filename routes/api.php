<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\QuestionController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/user', [AuthController::class, 'user'])->middleware('jwt');;
Route::post('/logout', [AuthController::class, 'logout'])->middleware('jwt');


Route::get('/getallunit', [UnitController::class, 'getAllUnit'])->middleware('jwt');
Route::get('/getallunitquestions/{id}', [UnitController::class, 'getAllUnitQuestions'])->middleware('jwt');

Route::post('/answerControl', [QuestionController::class, 'answerControl'])->middleware('jwt');
