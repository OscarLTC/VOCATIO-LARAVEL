<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function findById($id): JsonResponse
    {

        $result = Result::find($id);
        return response()->json($result);
    }
}
