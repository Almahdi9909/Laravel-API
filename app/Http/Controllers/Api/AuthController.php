<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as RulesPassword;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $request->validate([
            'name'          =>      'required | string | max:255',
            'email'         =>      'required | email | max:255 | unique:users',
            'password'      =>      ['required' , 'confirmed' , RulesPassword::default()],
            'device_name'   =>      'required'
        ]);


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        return $user->createToken($request->device_name)->plainTextToken;
        
    }
    public function logout(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if($user)
            $user->tokens()->delete();

            return response()->noContent();
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);
    
        $user = User::where('email', $request->email)->first();
    
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
    
        $token = [
            'token' => $user->createToken($request->device_name)->plainTextToken,
            'roles' => [
                'admin' => [
                    'permissions' => ['edit', 'delete' , 'create']
                ]
            ]
        ];
        return $token;
    }
}
