<?php

namespace App\Livewire\Auth;

use App\Events\NewUserCreated;
use App\Mail\EmailVerificationMail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class RegisterationForm extends Component
{
    public $email;
    public $password;
    public $password_confirmation;

    protected $rules = [
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|confirmed',
    ];

    public function registerUser()
    {
        $this->validate();
        try{
            DB::beginTransaction();
            $this->password = Hash::make($this->password);
            $user = User::create($this->all());
            if ($user) {
                NewUserCreated::dispatch($user);
                Auth::login($user);
                
                // Send OTP for email verification
                $this->sendVerificationOTP($user);
                
                DB::commit();
                session()->flash('message', 'Registration successful! Please verify your email.');
                return redirect()->route('verification.notice');
            }
            DB::rollback();
            session()->flash('message', 'Something went wrong while registering user');
            return;
        }catch(\Exception $e){
            DB::rollback();
            session()->flash('message', 'Something went wrong while registering user');
            return;
        }
    }

    private function sendVerificationOTP($user)
    {
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        $user->update([
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        try {
            Mail::to($user->email)->send(new EmailVerificationMail($user, $otp));
        } catch (\Exception $e) {
            // Silently fail - user can request a new OTP on the verification page
        }
    }

    public function render()
    {
        return view('livewire.auth.registeration-form');
    }
}
