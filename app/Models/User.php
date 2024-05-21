<?php

namespace App\Models;

use App\Mail\OtpMail;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Mail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'phone',
        'email',
        'password',
        'otp',
        'otp_expiry',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * The relation to the user type.
     *
     * @var array<string, string>
     */
    public function userType(): BelongsTo
    {
        return $this->belongsTo(UserType::class);
    }

    /**
     * Send OTP to the user's email.
     *
     * @return void
     */
    public function sendOtp()
    {
        $this->generateOtp();
        Mail::to($this->email)->send(new \App\Mail\OtpMail($this->otp));
    }

    /**
     * Generate a new OTP and save it to the user.
     *
     * @return void
     */
    public function generateOtp()
    {
        $this->otp = rand(100000, 999999);
        $this->otp_expiry = now()->addMinutes(10);
        $this->save();
    }

    public function isAdmin(): bool
    {
        return $this->userType->name === 'Admin' || $this->userType->name === 'Developer';
    }

    public function isActive(): bool
    {
        return $this->userType->is_active === 1;
    }
}
