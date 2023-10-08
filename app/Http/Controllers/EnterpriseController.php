<?php

namespace App\Http\Controllers;

use App\Models\Enterprise;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EnterpriseController extends Controller
{
    public function index(): JsonResponse
    {
        $enterprises = Enterprise::with('bussinesLine')->get()->map(function ($enterprise) {
            return collect($enterprise);
        });

        return response()->json($enterprises);
    }

    public function search($data)
    {
        $enterprises = Enterprise::where('name', 'like', "%$data%")
            ->orWhere('contactName', 'like', "%$data%")
            ->orWhere('phoneContact', 'like', "%$data%")
            ->orWhere('emailContact', 'like', "%$data%")
            ->with('bussinesLine')->get()->map(function ($person) {
                return collect($person);
            });

        return response()->json($enterprises);
    }

    public function findById($id): JsonResponse
    {
        $enterprise = Enterprise::with('bussinesLine')->find($id);
        return response()->json($enterprise);
    }

    public function save(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string',
            'contactName' => 'required|string',
            'phoneContact' => 'required|string',
            'emailContact' => 'required|string',
            'bussinesLine_id' => 'required|integer',
        ]);

        $enterprise = new Enterprise($data);
        $enterprise->save();

        $body = $enterprise->attributesToArray();

        return response()->json($body);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string',
            'contactName' => 'required|string',
            'phoneContact' => 'required|string',
            'emailContact' => 'required|string',
            'bussinesLine_id' => 'required|integer',
        ]);

        $enterprise = Enterprise::find($id);
        $enterprise->update($data);

        $body = $enterprise->attributesToArray();

        return response()->json($body);
    }

    public function delete($id)
    {
        $enterprise = Enterprise::find($id);
        $enterprise->person()->delete();
        $enterprise->delete();
    }

    public function enterpriseAmount(): JsonResponse
    {
        $enterprises = Enterprise::get();

        foreach ($enterprises as $enterprise) {
            $enterprise->amount = count($enterprise->surveyProgramming);
            unset($enterprise->contactName);
            unset($enterprise->phoneContact);
            unset($enterprise->emailContact);
            unset($enterprise->surveyProgramming);
        }


        return response()->json($enterprises);
    }
}
