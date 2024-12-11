<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
            return redirect()->route('app.home');
        }
        session()->flash('message', 'Login Failed, Incorrect Credentials');
        return;
    }

    public function render()
    {
        return view('livewire.auth.login-form');
    }
}
