<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\BussinesLineController;
use App\Http\Controllers\DocTypeController;
use App\Http\Controllers\EnterpriseController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ResultArchetypeController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\SurveyEnterpriseController;
use App\Http\Controllers\SurveyEnterprisePersonController;
use App\Http\Controllers\SurveyProgrammingController;
use App\Http\Controllers\SurveyProgrammingPersonController;
use App\Http\Controllers\UsersController;
use App\Models\SurveyEnterprisePerson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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
Route::post('person/import/{enterprise_id}', [PersonController::class, 'import']);
Route::put('person/{id}', [PersonController::class, 'update']);
Route::delete('person/{id}', [PersonController::class, 'delete']);

//Enterprise
Route::get('enterprise/all', [EnterpriseController::class, 'index']);
Route::get('enterprise/total', [EnterpriseController::class, 'enterpriseAmount']);
Route::get('enterprise/search/{data}', [EnterpriseController::class, 'search']);
Route::get('enterprise/{id}', [EnterpriseController::class, 'findById']);
Route::post('enterprise/save', [EnterpriseController::class, 'save']);
Route::put('enterprise/{id}', [EnterpriseController::class, 'update']);
Route::delete('enterprise/{id}', [EnterpriseController::class, 'delete']);

//Survey
Route::get('survey/all', [SurveyController::class, 'index']);
Route::get('survey/total', [SurveyController::class, 'surveyAmount']);
Route::get('survey/{id}', [SurveyController::class, 'findById']);

//State
Route::get('state/all', [StateController::class, 'index']);

//SurveyProgramming
Route::get('surveyProgramming/all', [SurveyProgrammingController::class, 'index']);
Route::get('surveyProgramming/total', [SurveyProgrammingController::class, 'surveyAmountPerMonth']);
Route::get('surveyProgramming/search/{data}', [SurveyProgrammingController::class, 'search']);
Route::post('surveyProgramming/save', [SurveyProgrammingController::class, 'save']);
Route::put('surveyProgramming/{id}', [SurveyProgrammingController::class, 'update']);
Route::delete('surveyProgramming/{id}', [SurveyProgrammingController::class, 'delete']);
Route::get('surveyProgramming/{id}', [SurveyProgrammingController::class, 'findById']);
Route::get('surveyProgramming/enterprise/{id}', [SurveyProgrammingController::class, 'findByEnterpriseId']);
Route::post('/surveyProgramming/{id}/export', [SurveyProgrammingController::class, 'exportById']);
Route::put('surveyProgramming/{id}/cancel', [SurveyProgrammingController::class, 'cancelSurvey']);

//SurveyEnterprisePerson
Route::get('surveyProgrammingPerson/all', [SurveyProgrammingPersonController::class, 'index']);
Route::get('surveyProgrammingPerson/totalSurveys', [SurveyProgrammingPersonController::class, 'totalSurveys']);
Route::get('surveyProgrammingPerson/pdfLocal', [SurveyProgrammingPersonController::class, 'getPdf']);

Route::post('surveyProgrammingPerson/pdf/{id}', [SurveyProgrammingPersonController::class, 'updatePdfBlob']);
Route::get('surveyProgrammingPerson/pdfDownload/{id}', [SurveyProgrammingPersonController::class, 'downloadPdfBlob']);
Route::get('surveyProgrammingPerson/{id}', [SurveyProgrammingPersonController::class, 'findById']);
// Route::put('surveyEnterprisePerson/result/{id}', [SurveyEnterprisePersonController::class, 'updateResult']);

//Answer
Route::get('answers/all', [AnswerController::class, 'index']);
Route::get('answers/last', [AnswerController::class, 'lastAnswers']);
Route::get('answers/{id}', [AnswerController::class, 'findBySurveyPerson']);
Route::post('answers/save', [AnswerController::class, 'createBySurvey']);

//Result
Route::get('result/{id}', [ResultController::class, 'findById']);

//ResultArchetype
Route::get('resultArchetype/all', [ResultArchetypeController::class, 'index']);
Route::get('resultArchetype/{id1}/{id2}/{id3}', [ResultArchetypeController::class, 'findByIds']);


// Users
Route::post('users/login', [UsersController::class, 'login']);
