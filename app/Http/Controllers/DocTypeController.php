<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DocType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DocTypeController extends Controller
{
    public function index(): JsonResponse
    {
        $doctypes = DocType::all();

        return response()->json($doctypes);
    }
}
