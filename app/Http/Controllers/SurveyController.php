<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function index(): JsonResponse
    {
        $surveys = Survey::get()->map(function ($survey) {
            return collect($survey);
        });
        return response()->json($surveys);
    }

    public function findById($id): JsonResponse
    {
        $survey = Survey::with('question', 'question.questionAlternative', 'question.questionAlternative.alternative', 'question.questionCategory', 'question.questionCategory.category')->find($id);

        return response()->json($survey);
    }

    public function surveyAmount(): JsonResponse
    {
        $surveys = Survey::get();

        foreach ($surveys as $survey) {
            $survey->amount = count($survey->surveyProgramming);
            unset($survey->surveyProgramming);
        }


        return response()->json($surveys);
    }
}
