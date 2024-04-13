<?php

namespace App\Http\Controllers;

use App\Exports\SurveyEnterprisePersonsExport;
use App\Models\Survey;
use App\Models\SurveyProgramming;
use App\Models\SurveyProgrammingPerson;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SurveyProgrammingController extends Controller
{
    public function index(): JsonResponse
    {
        $surveysProgramming = SurveyProgramming::with('survey', 'enterprise', 'state', 'surveyProgrammingPerson', 'surveyProgrammingPerson.state')
            ->get()->makeHidden(['pdfBlob']);
        return response()->json($surveysProgramming);
    }

    public function search($data)
    {
        $surveysProgramming = SurveyProgramming::where('name', 'like', "%$data%")
            ->with('survey', 'enterprise', 'state', 'surveyProgrammingPerson')->get()->map(function ($surveyProgramming) {
                return collect($surveyProgramming);
            });

        return response()->json($surveysProgramming);
    }

    public function save(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string',
            'section' => 'required|string',
            'surveyIds' => 'required|array',
            'enterprise_id' => 'required|integer',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
            'state_id' => 'required|integer',
            'surveyProgrammingPersonIds' => 'required|array',
            'surveyProgrammingPersonIds.*' => 'integer'
        ]);


        $surveyIds = $data['surveyIds'];


        foreach ($surveyIds as $sruevyId) {

            $surveyProgramming = new SurveyProgramming($data);
            $surveyProgramming->survey_id = $sruevyId;
            $surveyProgramming->save();

            $surveyProgrammingPersonIds = $data['surveyProgrammingPersonIds'];

            $surveyProgrammingPersons = [];
            foreach ($surveyProgrammingPersonIds as $personId) {
                $surveyProgrammingPersons[] = [
                    'surveyProgramming_id' => $surveyProgramming->id,
                    'person_id' => $personId,
                    'state_id' => 2
                ];
            }
            SurveyProgrammingPerson::insert($surveyProgrammingPersons);

            $body = $surveyProgramming->attributesToArray();
        }




        return response()->json($body);
    }

    public function findById($id): JsonResponse
    {
        $surveyProgramming = SurveyProgramming::with('survey', 'enterprise', 'state', 'surveyProgrammingPerson', 'surveyProgrammingPerson.person', 'surveyProgrammingPerson.state')->find($id);
        return response()->json($surveyProgramming);
    }


    public function findByEnterpriseId($id): JsonResponse
    {
        $surveyEnterprises = SurveyProgramming::where('enterprise_id', 'like', $id)->with('survey', 'enterprise', 'state', 'surveyProgrammingPerson', 'surveyProgrammingPerson.person', 'surveyProgrammingPerson.state')->get()->map(function ($surveyEnterprise) {
            return collect($surveyEnterprise);
        });
        return response()->json($surveyEnterprises);
    }

    public function exportById($id, Request $request)
    {
        $surveyEnterprise = SurveyProgramming::with('survey', 'enterprise', 'state', 'surveyProgrammingPerson', 'surveyProgrammingPerson.person')->find($id);
        $surveyEnterprisePersons = $surveyEnterprise->surveyProgrammingPerson;

        $docName = 'vocatio';

        $domain = $request->json('domain');

        return Excel::download(new SurveyEnterprisePersonsExport($surveyEnterprisePersons, $domain), $docName . '.xlsx');
    }


    public function update(Request $request, $id): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string',
            'section' => 'required|string',
            'enterprise_id' => 'required|integer',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
            'state_id' => 'required|integer',
            'surveyProgrammingPersonIds' => 'array',
            'surveyProgrammingPersonIds.*' => 'integer'
        ]);

        $surveyProgrammingPersonIds = $data['surveyProgrammingPersonIds'];

        unset($data['surveyProgrammingPersonIds'], $data['surveyProgrammingPersonIds.*']);


        $surveyProgramming = SurveyProgramming::find($id);

        $surveyProgramming->update($data);




        if (count($surveyProgrammingPersonIds) > 0) {
            $surveyProgrammingPersons = [];
            foreach ($surveyProgrammingPersonIds as $personId) {
                $surveyProgrammingPersons[] = [
                    'surveyProgramming_id' => $id,
                    'person_id' => $personId,
                    'state_id' => 2
                ];
            }
            SurveyProgrammingPerson::insert($surveyProgrammingPersons);
        }

        $body = $surveyProgramming->attributesToArray();

        return response()->json($body);
    }



    public function delete($id)
    {
        $surveyProgramming = SurveyProgramming::find($id);

        if ($surveyProgramming) {
            $surveyProgramming->surveyProgrammingPerson()->with('answers')->get()->each(function ($surveyProgrammingPerson) {
                $surveyProgrammingPerson->answers()->delete();
                $surveyProgrammingPerson->delete();
            });
            $surveyProgramming->delete();
            return response()->json(['message' => 'Encuesta de empresa eliminada correctamente']);
        }

        return response()->json(['message' => 'Encuesta de empresa no encontrada'], 404);
    }

    public function cancelSurvey($id)
    {
        $surveyEnterprise = SurveyProgramming::find($id);
        $surveyEnterprise->state_id = 4;
        $surveyEnterprise->save();
        return response()->json($surveyEnterprise);
    }



    // public function surveyAmountPerMonth()
    // {
    //     $startDate = date('Y') . '-01-01';

    //     $surveys = SurveyProgramming::where('startDate', '>=', $startDate)->get();

    //     $surveyIds = $surveys->pluck('survey_id')->unique()->filter();

    //     $surveyData = Survey::whereIn('id', $surveyIds)->get();

    //     $surveyNames = $surveyData->pluck('name', 'id');

    //     $surveyCounts = [];

    //     $months = ['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december'];
    //     foreach ($surveyNames as $surveyId => $surveyName) {
    //         $surveyCounts[$surveyName] = [];
    //         foreach ($months as $month) {
    //             $surveyCounts[$surveyName][$month] = 0;
    //         }
    //     }

    //     foreach ($surveys as $survey) {
    //         $month = strtolower(date('F', strtotime($survey->startDate)));
    //         $surveyId = $survey->survey_id;

    //         // Incrementar el contador para la encuesta y el mes correspondiente
    //         if (isset($surveyNames[$surveyId])) {
    //             $surveyName = $surveyNames[$surveyId];
    //             $surveyCounts[$surveyName][$month]++;
    //         }
    //     }

    //     return response()->json($surveyCounts);
    // }

    public function surveyAmountPerMonth()
    {
        $startDate = date('Y') . '-01-01';

        $surveys = SurveyProgramming::where('startDate', '>=', $startDate)->get();

        $surveyNames = Survey::pluck('name', 'id');
        $months = ['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december'];

        $surveyCounts = [];

        foreach ($surveyNames as $surveyId => $surveyName) {
            $surveyCounts[$surveyName] = [];
            foreach ($months as $month) {
                $surveyCounts[$surveyName][$month] = 0;
            }
        }

        foreach ($surveys as $survey) {
            $month = strtolower(date('F', strtotime($survey->startDate)));
            $surveyId = $survey->survey_id;

            if (isset($surveyNames[$surveyId])) {
                $surveyName = $surveyNames[$surveyId];
                $surveyCounts[$surveyName][$month]++;
            }
        }

        return response()->json($surveyCounts);
    }
}
