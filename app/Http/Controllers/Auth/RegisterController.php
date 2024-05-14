<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\UserType;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\UserCreateRequest;

class RegisterController extends Controller
{
    public function index()
    {
        $userTypes = UserResource::collection(UserType::all());
        
        return view('auth.register-user', compact('userTypes'));
    }
    
    /**
     * Register user by register method.
     */
    
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
        $user->created_by = Auth::user()->username;

        $user->save();

        // event(new Registered($user));
        
        return redirect()->route('home')->with('status', 'User registered successfully');
     }
}
