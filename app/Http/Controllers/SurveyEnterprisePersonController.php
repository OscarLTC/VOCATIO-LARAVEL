<?php

namespace App\Http\Controllers;

use App\Models\SurveyEnterprisePerson;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SurveyEnterprisePersonController extends Controller
{
    public function index(): JsonResponse
    {
        $surveysEnterprisesPerson = SurveyEnterprisePerson::with('surveyEnterprise', 'surveyEnterprise.survey', 'surveyEnterprise.enterprise', 'surveyEnterprise.state', 'person', 'result', 'state')
            ->get()
            ->map(function ($surveyEnterprisePerson) {
                return collect($surveyEnterprisePerson);
            });
        return response()->json($surveysEnterprisesPerson);
    }

    public function findById($id): JsonResponse
    {
        $surveyEnterprisePerson = SurveyEnterprisePerson::with('surveyEnterprise', 'surveyEnterprise.survey', 'surveyEnterprise.survey.question', 'surveyEnterprise.survey.question.alternative', 'surveyEnterprise.enterprise', 'surveyEnterprise.state', 'person', 'result', 'state', 'answers', 'answers.alternative')->find($id);

        return response()->json($surveyEnterprisePerson);
    }

    public function updateResult(Request $request, $id)
    {
        $surveyEnterprisePerson = SurveyEnterprisePerson::find($id);

        if (!$surveyEnterprisePerson) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        $surveyEnterprisePerson->result_id = $request->input('result_id');
        $surveyEnterprisePerson->end_date = date('Y-m-d');
        $surveyEnterprisePerson->save();

        return response()->json(['message' => 'Campo result_id actualizado con éxito']);
    }
}
