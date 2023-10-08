<?php

namespace App\Http\Controllers;

use App\Models\DocType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class DocTypeController extends Controller
{
    public function index(): JsonResponse
    {
        $doctypes = DocType::all();

        return response()->json($doctypes);
    }
}
