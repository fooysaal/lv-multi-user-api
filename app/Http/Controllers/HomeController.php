<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = UserResource::collection(User::all());
        
        return view('home', compact('users'));
    }

    public function profile()
    {
        return view('auth.profile');
    }

    public function updateProfile(UserUpdateRequest $request)
    {
        $user = User::find(auth()->user()->id);

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

        return redirect()->route('profile')->with('success', 'Profile updated successfully');
    }

    public function destroyProfile(Request $request)
    {
        $user = User::find(auth()->user()->id);

        // delete user if matches the password
        if(!Hash::check($request->password, $user->password))
        {
            return redirect()->route('profile')->with('success', 'Password does not match');
        }

        $user->delete();

        return redirect()->route('login')->with('success', 'Profile deleted successfully');
    }
}
