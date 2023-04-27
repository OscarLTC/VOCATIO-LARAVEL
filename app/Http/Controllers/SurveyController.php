<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function index(): JsonResponse
    {
        $survey = Survey::all();

        return response()->json($survey);
    }
}
