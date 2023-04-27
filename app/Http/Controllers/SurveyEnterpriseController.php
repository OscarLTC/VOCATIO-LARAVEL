<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use App\Models\SurveyEnterprise;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SurveyEnterpriseController extends Controller
{
    public function index(): JsonResponse
    {
        $surveysEnterprises = SurveyEnterprise::with('survey', 'enterprise', 'state')->get()->map(function ($surveyEnterprise) {
            return collect($surveyEnterprise);
        });

        return response()->json($surveysEnterprises);
    }

    public function search($data)
    {
        $surveysEnterprises = SurveyEnterprise::where('name', 'like', "%$data%")
            ->with('survey', 'enterprise', 'state')->get()->map(function ($surveyEnterprise) {
                return collect($surveyEnterprise);
            });

        return response()->json($surveysEnterprises);
    }

    public function findById($id): JsonResponse
    {
        $surveyEnterprise = SurveyEnterprise::with('survey', 'enterprise', 'state')->find($id);
        return response()->json($surveyEnterprise);
    }

    public function save(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string',
            'survey_id' => 'required|integer',
            'enterprise_id' => 'required|integer',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
            'state_id' => 'required|integer',
        ]);

        $surveyEnterprise = new SurveyEnterprise($data);
        $surveyEnterprise->save();

        $body = $surveyEnterprise->attributesToArray();

        return response()->json($body);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string',
            'survey_id' => 'required|integer',
            'enterprise_id' => 'required|integer',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
            'state_id' => 'required|integer',
        ]);

        $surveyEnterprise = SurveyEnterprise::find($id);
        $surveyEnterprise->update($data);

        $body = $surveyEnterprise->attributesToArray();

        return response()->json($body);
    }

    public function delete($id)
    {
        $surveyEnterprise = SurveyEnterprise::find($id);
        $surveyEnterprise->delete();
    }

    public function cancelSurvey($id)
    {
        $surveyEnterprise = SurveyEnterprise::find($id);
        $surveyEnterprise->state_id = 4;
        $surveyEnterprise->save();
        return response()->json($surveyEnterprise);
    }
}
