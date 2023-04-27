<?php

use App\Http\Controllers\BussinesLineController;
use App\Http\Controllers\DocTypeController;
use App\Http\Controllers\EnterpriseController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\SurveyEnterpriseController;
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

//Person
Route::get('person/all', [PersonController::class, 'index']);
Route::get('person/search/{data}', [PersonController::class, 'search']);
Route::get('person/{id}', [PersonController::class, 'findById']);
Route::post('person/save', [PersonController::class, 'save']);
Route::put('person/{id}', [PersonController::class, 'update']);
Route::delete('person/{id}', [PersonController::class, 'delete']);

//Enterprise
Route::get('enterprise/all', [EnterpriseController::class, 'index']);
Route::get('enterprise/search/{data}', [EnterpriseController::class, 'search']);
Route::get('enterprise/{id}', [EnterpriseController::class, 'findById']);
Route::post('enterprise/save', [EnterpriseController::class, 'save']);
Route::put('enterprise/{id}', [EnterpriseController::class, 'update']);
Route::delete('enterprise/{id}', [EnterpriseController::class, 'delete']);

//Survey
Route::get('survey/all', [SurveyController::class, 'index']);

//State
Route::get('state/all', [StateController::class, 'index']);

//SurveyEnterprise
Route::get('surveyEnterprise/all', [SurveyEnterpriseController::class, 'index']);
Route::get('surveyEnterprise/search/{data}', [SurveyEnterpriseController::class, 'search']);
Route::get('surveyEnterprise/{id}', [SurveyEnterpriseController::class, 'findById']);
Route::post('surveyEnterprise/save', [SurveyEnterpriseController::class, 'save']);
Route::put('surveyEnterprise/{id}', [SurveyEnterpriseController::class, 'update']);
Route::put('surveyEnterprise/{id}/cancel', [SurveyEnterpriseController::class, 'cancelSurvey']);
Route::delete('surveyEnterprise/{id}', [SurveyEnterpriseController::class, 'delete']);

//Excel
Route::post('excel/import', [ExcelController::class, 'import']);
