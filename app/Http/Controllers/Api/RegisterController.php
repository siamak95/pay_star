<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $requset)
    {
        try {
            User::create([
                'first_name' => $requset->first_name,
                'last_name' => $requset->last_name,
                'email' => $requset->email,
                'password' => Hash::make($requset->first_name),
                'national_code' => $requset->national_code
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'data' => 'user registerd'
        ], 201);
    }

    
}
