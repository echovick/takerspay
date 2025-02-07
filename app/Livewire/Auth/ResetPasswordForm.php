<?php
namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class ResetPasswordForm extends Component
{
    public $password;
    public $password_confirmation;
    public $token;

    public function mount(Request $request)
    {
        $this->token = $request->query('token'); // Retrieve the token from URL
    }

    public function resetPassword()
    {
        $this->validate([
            'password' => 'required|min:8|confirmed',
            'token'    => 'required|string|exists:password_reset_tokens,token',
        ]);
        $existingToken = DB::table('password_reset_tokens')
            ->where('token', $this->token)
            ->first();
        $user           = User::where('email', $existingToken->email)->first();
        $user->password = bcrypt($this->password);
        $user->save();

        // Send email notification
        Mail::send('mail.password-changed-notification', ['email' => $existingToken->email], function ($message) use ($existingToken) {
            $message->to($existingToken->email)
                ->subject('Password Was Reset');
        });

        DB::table('password_reset_tokens')->where('token', $this->token)->delete();

        session()->flash('message', 'Your password has been reset successfully. You can now login with your new password');
    }

    public function render()
    {
        return view('livewire.auth.reset-password-form');
    }
}
