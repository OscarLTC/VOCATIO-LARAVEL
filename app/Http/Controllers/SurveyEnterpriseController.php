<?php

namespace App\Http\Controllers;

use App\Exports\SurveyEnterprisePersonsExport;
use App\Models\SurveyEnterprise;
use App\Models\SurveyEnterprisePerson;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SurveyEnterpriseController extends Controller
{
    public function index(): JsonResponse
    {
        $surveysEnterprises = SurveyEnterprise::with('survey', 'enterprise', 'state', 'surveyEnterprisePersons', 'surveyEnterprisePersons.state')->get()->map(function ($surveyEnterprise) {
            return collect($surveyEnterprise);
        });

        return response()->json($surveysEnterprises);
    }

    public function search($data)
    {
        $surveysEnterprises = SurveyEnterprise::where('name', 'like', "%$data%")
            ->with('survey', 'enterprise', 'state', 'surveyEnterprisePersons', 'surveyEnterprisePersons.state')->get()->map(function ($surveyEnterprise) {
                return collect($surveyEnterprise);
            });

        return response()->json($surveysEnterprises);
    }

    public function findById($id): JsonResponse
    {
        $surveyEnterprise = SurveyEnterprise::with('survey', 'enterprise', 'state', 'surveyEnterprisePersons', 'surveyEnterprisePersons.person', 'surveyEnterprisePersons.person.genre', 'surveyEnterprisePersons.state')->find($id);
        return response()->json($surveyEnterprise);
    }

    public function exportById($id, Request $request)
    {
        $surveyEnterprise = SurveyEnterprise::with('survey', 'enterprise', 'state', 'surveyEnterprisePersons', 'surveyEnterprisePersons.person', 'surveyEnterprisePersons.person.genre', 'surveyEnterprisePersons.state')->find($id);
        $surveyEnterprisePersons = $surveyEnterprise->surveyEnterprisePersons;

        $docName = 'vocatio';

        $domain = $request->json('domain');

        return Excel::download(new SurveyEnterprisePersonsExport($surveyEnterprisePersons, $domain), $docName . '.xlsx');
    }

    public function findByEnterpriseId($id): JsonResponse
    {
        $surveyEnterprises = SurveyEnterprise::where('enterprise_id', 'like', $id)->with('survey', 'enterprise', 'state', 'surveyEnterprisePersons', 'surveyEnterprisePersons.person', 'surveyEnterprisePersons.person.genre', 'surveyEnterprisePersons.state')->get()->map(function ($surveyEnterprise) {
            return collect($surveyEnterprise);
        });
        return response()->json($surveyEnterprises);
    }

    public function save(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string',
            'section' => 'required|string',
            'survey_id' => 'required|integer',
            'enterprise_id' => 'required|integer',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
            'state_id' => 'required|integer',
            'surveyEnterprisePersonIds' => 'required|array',
            'surveyEnterprisePersonIds.*' => 'integer'
        ]);

        $surveyEnterprise = new SurveyEnterprise($data);
        $surveyEnterprise->save();

        $surveyEnterprisePersonIds = $data['surveyEnterprisePersonIds'];

        $surveyEnterprisePersons = [];
        foreach ($surveyEnterprisePersonIds as $personId) {
            $surveyEnterprisePersons[] = [
                'surveyEnterprise_id' => $surveyEnterprise->id,
                'person_id' => $personId,
                'result_id' => null,
                'state_id' => 2
            ];
        }

        SurveyEnterprisePerson::insert($surveyEnterprisePersons);

        $body = $surveyEnterprise->attributesToArray();

        return response()->json($body);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string',
            'section' => 'required|string',
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

        if ($surveyEnterprise) {
            $surveyEnterprise->surveyEnterprisePersons()->with('answers')->get()->each(function ($surveyEnterprisePerson) {
                $surveyEnterprisePerson->answers()->delete();
                $surveyEnterprisePerson->delete();
            });
            $surveyEnterprise->delete();
            return response()->json(['message' => 'Encuesta de empresa eliminada correctamente']);
        }

        return response()->json(['message' => 'Encuesta de empresa no encontrada'], 404);
    }

    public function cancelSurvey($id)
    {
        $surveyEnterprise = SurveyEnterprise::find($id);
        $surveyEnterprise->state_id = 4;
        $surveyEnterprise->save();
        return response()->json($surveyEnterprise);
    }
}
