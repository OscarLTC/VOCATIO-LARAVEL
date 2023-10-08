<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\SurveyEnterprisePerson;
use App\Models\SurveyProgrammingPerson;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function index(): JsonResponse
    {
        $answers = Answer::all();

        return response()->json($answers);
    }

    public function findBySurveyPerson($id): JsonResponse
    {
        $answers = Answer::with('questionAlternative')->where('surveyProgrammingPerson_id', $id)->get();

        return response()->json($answers);
    }

    public function createBySurvey(Request $request)
    {
        $data = $request->validate([
            'answers' => 'required|array',
            'id' => 'required|integer'
        ]);

        $answers = $data['answers'];

        foreach ($answers as $answer) {
            $questionCategory_id = $answer[0];
            $questionAlternative_id = $answer[1];

            Answer::create([
                'surveyProgrammingPerson_id' => $data['id'],
                'questionCategory_id' => $questionCategory_id,
                'questionAlternative_id' => $questionAlternative_id,
            ]);
        }

        $surveyPerson = SurveyProgrammingPerson::find($data['id']);
        $surveyPerson->state_id = 3;
        $surveyPerson->endDate = date("Y-m-d");
        $surveyPerson->save();

        return response()->json(['message' => $data]);
    }

    public function lastAnswers()
    {
        $answers = Answer::with('surveyProgrammingPerson', 'surveyProgrammingPerson.person', 'surveyProgrammingPerson.surveyProgramming.enterprise', 'surveyProgrammingPerson.surveyProgramming.survey')->get();



        return response()->json($answers[0]);
    }
}
