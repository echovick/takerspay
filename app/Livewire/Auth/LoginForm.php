<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class LoginForm extends Component
{
    public $email;
    public $password;

    protected $rules = [
        'email' => 'required|email|exists:users,email',
        'password' => 'required|string'
    ];

    public function login()
    {
        $this->validate();
        $user = User::where('email', $this->email)->first();
        if(Hash::check($this->password, $user->password)){
            Auth::login($user);
            
            // Check if email is verified
            if (is_null($user->email_verified_at)) {
                // Send OTP for email verification
                $this->sendVerificationOTP($user);
                return redirect()->route('verification.notice');
            }
            
            return redirect()->route('app.home');
        }
        session()->flash('message', 'Login Failed, Incorrect Credentials');
        return;
    }

    private function sendVerificationOTP($user)
    {
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        $user->update([
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        try {
            Mail::raw("Your verification code is: $otp\n\nThis code will expire in 10 minutes.", function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Email Verification Code - TakersPay');
            });
        } catch (\Exception $e) {
            // Silently fail - user can request a new OTP on the verification page
        }
    }

    public function render()
    {
        return view('livewire.auth.login-form');
    }
}
