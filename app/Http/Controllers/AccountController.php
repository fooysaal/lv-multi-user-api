<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
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

    // public function trashedUsers()
    // {
    //     $users = User::onlyTrashed()->get();

    //     return view('home', compact('users'));
    // }

    public function restoreUsers($id)
    {
        $user = User::withTrashed()->findorFail($id);
        $user->restore();

        return redirect()->route('home')->with('status', 'User profile restored successfully');
    }

    public function forceDeleteUser($id)
    {
        $user = User::withTrashed()->findorFail($id);
        $user->forceDelete();

        return redirect()->route('home')->with('status', 'User profile deleted permanently');
    }
}
