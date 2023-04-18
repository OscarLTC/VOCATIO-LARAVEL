<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PHPUnit\Framework\MockObject\Stub\ReturnReference;

class StudentController extends Controller
{
    public function index(): JsonResponse
    {
        $students = Student::with('docType', 'enterprise', 'enterprise.bussinesLine')->get()->map(function ($student) {
            return collect($student);
        });

        return response()->json($students);
    }

    public function findById($id): JsonResponse
    {
        $student = Student::with('docType', 'enterprise')->find($id);
        return response()->json($student);
    }

    public function save(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string',
            'lastName' => 'required|string',
            'emailAddress' => 'required|string',
            'docType_id' => 'required|integer',
            'docNumber' => 'required|string',
            'phoneNumber' => 'required|string',
        ]);

        $student = new Student($data);
        $student->save();

        $body = $student->attributesToArray();

        return response()->json($body);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string',
            'lastName' => 'required|string',
            'emailAddress' => 'required|string',
            'docType_id' => 'required|integer',
            'docNumber' => 'required|string',
            'phoneNumber' => 'required|string',
        ]);

        $student = Student::find($id);
        $student->update($data);

        $body = $student->attributesToArray();

        return response()->json($body);
    }

    public function delete($id)
    {
        $student = Student::find($id);
        $student->delete();
    }
}
