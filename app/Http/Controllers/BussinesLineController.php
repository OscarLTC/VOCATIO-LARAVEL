<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BussinesLine;
use Illuminate\Http\JsonResponse;

class BussinesLineController extends Controller
{
    public function index(): JsonResponse
    {
        $bussinesline = BussinesLine::all();

        return response()->json($bussinesline);
    }
}
