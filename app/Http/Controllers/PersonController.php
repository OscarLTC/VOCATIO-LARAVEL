<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

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

    public function import(Request $request, $enterprise_id)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xls,xlsx',
        ]);

        $file = $request->file('excel_file');

        $spreadsheet = IOFactory::load($file);

        $worksheet = $spreadsheet->getActiveSheet();

        $importedPeople = [];

        $rows = $worksheet->toArray();
        foreach ($rows as $index => $row) {

            if ($index === 0) {
                continue;
            }

            $name = $row[0];
            $lastName = $row[1];
            $emailAddress = $row[2];
            $docNumber = $row[3];
            $phoneNumber = $row[4];

            $person = new Person([
                'name' => $name,
                'lastName' => $lastName,
                'emailAddress' => $emailAddress,
                'docType_id' => 1,
                'enterprise_id' => $enterprise_id,
                'docNumber' => $docNumber,
                'phoneNumber' => $phoneNumber,
            ]);

            $person->save();
            $importedPeople[] = $person;
        }

        return response()->json($importedPeople);
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
