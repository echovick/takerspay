<?php

namespace App\Livewire\Auth;

use App\Events\NewUserCreated;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
                DB::commit();
                session()->flash('message', 'Registration Successful');
                return redirect()->route('login');
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

    public function render()
    {
        return view('livewire.auth.registeration-form');
    }
}
