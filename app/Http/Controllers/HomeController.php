<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserTypeResource;
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
        // return users with trashed users
        $viewBag['users'] = UserResource::collection(User::withTrashed()->get());

        $viewBag['userTypes'] = UserTypeResource::collection(UserType::where('is_active', 1)->get());
        
        return view('home', compact('viewBag'));
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
        
        if($user->isDirty())
        {
            $user->update();

            return redirect()->route('profile')->with('success', 'Profile updated successfully');
        }
        return redirect()->route('profile');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed'
        ]);
        
        $user = User::find(auth()->user()->id);
        
        // check if the old password matches
        if(!Hash::check($request->current_password, $user->password))
        {
            return redirect()->route('profile')->with('success', 'Old password does not match');
        }

        $user->password = Hash::make($request->password);
        $user->update();

        return redirect()->route('profile')->with('success', 'Password updated successfully');
    }

    public function destroyProfile(Request $request)
    {
        $user = User::find(auth()->user()->id);
        $request->validate([
            'account_delete_password' => 'required'
        ]);

        // delete user if matches the password
        if(!Hash::check($request->account_delete_password, $user->password))
        {
            return redirect()->route('profile')->with('success', 'Password does not match');
        }

        $user->delete();

        return redirect()->route('login');
    }
}
