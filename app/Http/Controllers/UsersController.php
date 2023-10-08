<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);



        $user = Users::where('username', $credentials['username'])->first();

        if ($user && ($user->password == $credentials['password'])) {
            return response()->json(['user' => $user]);
        } else {
            return response()->json(['message' => 'Credenciales inválidas'], 401);
        }
    }
}
