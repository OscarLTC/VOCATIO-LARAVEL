<?php

use App\Http\Controllers\BussinesLineController;
use App\Http\Controllers\DocTypeController;
use App\Http\Controllers\EnterpriseController;
use App\Http\Controllers\StudentController;
use App\Models\Enterprise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


//DocType
Route::get('doctype/all', [DocTypeController::class, 'index']);

//BussinesLine
Route::get('bussinesline/all', [BussinesLineController::class, 'index']);

//Student
Route::get('student/all', [StudentController::class, 'index']);
Route::get('student/{id}', [StudentController::class, 'findById']);
Route::post('student/save', [StudentController::class, 'save']);
Route::put('student/{id}', [StudentController::class, 'update']);
Route::delete('student/{id}', [StudentController::class, 'delete']);

//Enterprise
Route::get('enterprise/all', [EnterpriseController::class, 'index']);
Route::get('enterprise/{id}', [EnterpriseController::class, 'findById']);
Route::post('enterprise/save', [EnterpriseController::class, 'save']);
Route::put('enterprise/{id}', [EnterpriseController::class, 'update']);
Route::delete('enterprise/{id}', [EnterpriseController::class, 'delete']);
