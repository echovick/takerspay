<?php
namespace App\Livewire\Auth;

use App\Mail\EmailVerificationMail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class EmailVerificationForm extends Component
{
    public $otp;
    public $email;
    public $otpSent  = false;
    public $cooldown = 0;

    protected $rules = [
        'otp' => 'required|string|size:6',
    ];

    public function mount()
    {
        $user        = Auth::user();
        $this->email = $user->email;

        // If user doesn't have an OTP, send one automatically
        if (! $user->otp || ! $user->otp_expires_at) {
            $this->sendOtp();
        }

        if (session('otp_cooldown_expires_at') && now() < session('otp_cooldown_expires_at')) {
            $this->cooldown = now()->diffInSeconds(session('otp_cooldown_expires_at'));
        }
    }

    public function sendOtp()
    {
        if ($this->cooldown > 0) {
            return;
        }

        $user = Auth::user();
        $otp  = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $user->update([
            'otp'            => $otp,
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        try {
            Mail::to($user->email)->send(new EmailVerificationMail($user, $otp));

            $this->otpSent  = true;
            $this->cooldown = 60;
            session(['otp_cooldown_expires_at' => now()->addSeconds(60)]);
            session()->flash('message', 'Verification code sent to your email!');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to send verification code. Please try again.');
        }
    }

    public function verifyEmail()
    {
        try {
            $this->validate();

            $user = Auth::user();

            // Debug logging
            Log::info('Verification attempt', [
                'user_id'        => $user->id,
                'entered_otp'    => $this->otp,
                'stored_otp'     => $user->otp,
                'otp_expires_at' => $user->otp_expires_at,
                'current_time'   => now(),
            ]);

            if (! $user->otp || ! $user->otp_expires_at) {
                session()->flash('error', 'No verification code found. Please request a new one.');
                return;
            }

            if (now() > $user->otp_expires_at) {
                session()->flash('error', 'Verification code has expired. Please request a new one.');
                return;
            }

            if ($this->otp !== $user->otp) {
                session()->flash('error', 'Invalid verification code. Please try again.');
                return;
            }

            $user->update([
                'email_verified_at' => now(),
                'otp'               => null,
                'otp_expires_at'    => null,
            ]);

            session()->flash('message', 'Email verified successfully!');
            return redirect()->route('app.home');
        } catch (\Exception $e) {
            Log::error('Email verification error', ['error' => $e->getMessage()]);
            session()->flash('error', 'An error occurred during verification. Please try again.');
        }
    }

    public function updateCooldown()
    {
        if (session('otp_cooldown_expires_at') && now() < session('otp_cooldown_expires_at')) {
            $this->cooldown = now()->diffInSeconds(session('otp_cooldown_expires_at'));
        } else {
            $this->cooldown = 0;
            session()->forget('otp_cooldown_expires_at');
        }
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.auth.email-verification-form');
    }
}
