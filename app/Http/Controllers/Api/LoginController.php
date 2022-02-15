<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException ;

class LoginController extends Controller 
{
    public function __invoke(LoginRequest $requset)
    {
        $user = User::where('email', $requset['email'])->first();
        if (! $user ||  Hash::check($requset['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        return $user->createToken('token_base_name')->plainTextToken;
    }
}