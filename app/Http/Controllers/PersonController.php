<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Person;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function index(): JsonResponse
    {
        $people = Person::with('docType', 'enterprise', 'enterprise.bussinesLine')->get()->map(function ($person) {
            return collect($person);
        });

        return response()->json($people);
    }


    public function search($data)
    {
        $people = Person::where('name', 'like', "%$data%")
            ->orWhere('lastName', 'like', "%$data%")
            ->orWhere('emailAddress', 'like', "%$data%")
            ->orWhere('docNumber', 'like', "%$data%")
            ->orWhere('phoneNumber', 'like', "%$data%")
            ->with('docType', 'enterprise', 'enterprise.bussinesLine')->get()->map(function ($person) {
                return collect($person);
            });

        return response()->json($people);
    }

    public function findById($id): JsonResponse
    {
        $person = Person::with('docType', 'enterprise')->find($id);
        return response()->json($person);
    }

    public function save(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string',
            'lastName' => 'required|string',
            'emailAddress' => 'required|string',
            'docType_id' => 'required|integer',
            'enterprise_id' => 'required|integer',
            'docNumber' => 'required|string',
            'phoneNumber' => 'required|string',
        ]);

        $person = new Person($data);
        $person->save();

        $body = $person->attributesToArray();

        return response()->json($body);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string',
            'lastName' => 'required|string',
            'emailAddress' => 'required|string',
            'docType_id' => 'required|integer',
            'enterprise_id' => 'required|integer',
            'docNumber' => 'required|string',
            'phoneNumber' => 'required|string',
        ]);

        $person = Person::find($id);
        $person->update($data);

        $body = $person->attributesToArray();

        return response()->json($body);
    }

    public function delete($id)
    {
        $person = Person::find($id);
        $person->delete();
    }
}
