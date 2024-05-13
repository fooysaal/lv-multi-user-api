<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(UserCreateRequest $request)
    {
        $user = new User();

        // if($request->user_type_id)
        // {
        //     $user->user_type_id = $request->user_type_id;
        // }else{
        //     $user->user_type_id = 2;
        // }
        $user->user_type_id = $request->user_type_id;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->username = $request->username;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $user->save();
        
        // $token = $user->createToken('auth_token')->plainTextToken;
        
        return response()->json([
            // 'access_token' => $token,
            // 'token_type' => 'Bearer',
            'message' => 'User registered successfully',
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'message' => 'User logged in successfully',
        ]);
    }

    public function profile(Request $request)
    {
        return response()->json([
            'user' => new UserResource($request->user()),
        ]);
    }

    public function updateProfile(UserUpdateRequest $request)
    {
        $user = User::findorFail($request->user()->id);

        if($request->user_type_id)
        {
            $user->user_type_id = $request->user_type_id;
        }

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->username = $request->username;
        $user->phone = $request->phone;
        $user->email = $request->email;

        if($request->password)
        {
            $user->password = Hash::make($request->password);
        }

        $user->update();

        return response()->json([
            'message' => 'User updated successfully',
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out',
        ]);
    }
}
