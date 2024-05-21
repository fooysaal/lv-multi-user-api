<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    public function show()
    {
        return view('auth.verify');
    }

    public function verify(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'otp' => 'required|numeric'
        ]);

        if($user->otp !== $request->otp) {
            return back()->with('error', 'Invalid OTP');
        }

        if(Carbon::now()->greaterThan($user->otp_expiry)) {
            return back()->with('error', 'OTP expired');
        }

        $user->email_verified_at = Carbon::now();
        $user->otp = null;
        $user->otp_expiry = null;
        $user->save();

        return redirect()->route('home')->with('status', 'Email verified successfully');
    }

    public function resend()
    {
        $user = Auth::user();

        $user->sendOtp();

        return back()->with('status', 'OTP sent successfully');
    }
}
