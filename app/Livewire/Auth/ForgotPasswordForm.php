<?php
namespace App\Livewire\Auth;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Component;

class ForgotPasswordForm extends Component
{
    public $email;
    public $passwordResetTokenSent = false;

    public function forgotPassword()
    {
        $this->validate(['email' => 'required|email|exists:users,email']);
        $this->generatePasswordResetToken();
        $token = $this->generatePasswordResetToken();
        $url   = url('/reset-password?token=' . $token);

        Mail::send('mail.password-reset', ['url' => $url], function ($message) {
            $message->to($this->email)
                ->subject('Password Reset Request');
        });

        $this->passwordResetTokenSent = true;
    }

    public function generatePasswordResetToken()
    {
        $existingToken = DB::table('password_reset_tokens')
            ->where('email', $this->email)
            ->first();

        if ($existingToken) {
            return $existingToken->token;
        }

        $token = Str::random(60);

        DB::table('password_reset_tokens')->insert([
            'email'      => $this->email,
            'token'      => $token,
            'created_at' => Carbon::now(),
        ]);

        return $token;
    }

    public function render()
    {
        return view('livewire.auth.forgot-password-form');
    }
}
