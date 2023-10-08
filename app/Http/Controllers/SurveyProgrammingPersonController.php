<?php

namespace App\Http\Controllers;

use App\Models\SurveyProgrammingPerson;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SurveyProgrammingPersonController extends Controller
{
    public function index(): JsonResponse
    {
        $surveyProgrammingPersons = SurveyProgrammingPerson::with('surveyProgramming', 'person', 'answers')
            ->get()
            ->makeHidden(['pdfBlob'])
            ->map(function ($surveyProgrammingPerson) {
                return $surveyProgrammingPerson;
            });
        return response()->json($surveyProgrammingPersons);
    }

    public function findById($id): JsonResponse
    {
        $surveyProgrammingPerson = SurveyProgrammingPerson::with('surveyProgramming', 'surveyProgramming.enterprise', 'surveyProgramming.survey', 'surveyProgramming.survey.question', 'person', 'answers', 'answers.questionCategory', 'answers.questionCategory.category', 'answers.questionCategory.category.group', 'answers.questionAlternative', 'state')->find($id);

        return response()->json($surveyProgrammingPerson);
    }

    public function totalSurveys()
    {
        $surveyProgrammingPersons = SurveyProgrammingPerson::all();

        $count = 0;
        foreach ($surveyProgrammingPersons as $item) {
            if ($item["state_id"] == 3) {
                $count++;
            }
        }



        return response()->json(['total' => count($surveyProgrammingPersons), 'answered' => $count]);
    }

    public function updatePdfBlob(Request $request, $id)
    {
        $person = SurveyProgrammingPerson::find($id);

        if (!$person) {
            return response()->json(['message' => 'SurveyProgrammingPerson no encontrado'], 404);
        }

        $pdf = $request->getContent();
        $person->pdfBlob = $pdf;
        $person->save();

        return response()->json(['message' => 'SurveyProgrammingPerson actualizado correctamente'], 200);
    }
}
