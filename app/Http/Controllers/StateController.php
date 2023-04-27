<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\State;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function index(): JsonResponse
    {
        $states = State::all();

        return response()->json($states);
    }
}
