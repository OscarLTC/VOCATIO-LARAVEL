<?php

namespace App\Http\Controllers;

use App\Models\BussinesLine;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BussinesLineController extends Controller
{
    public function index(): JsonResponse
    {
        $bussinesline = BussinesLine::all();

        return response()->json($bussinesline);
    }
}
