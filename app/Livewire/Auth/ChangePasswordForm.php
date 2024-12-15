<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ChangePasswordForm extends Component
{
    public $currentPassword;
    public $password;
    public $password_confirmation;
    public $errorMsg;
    public $successMsg;

    protected $rules = [
        'password' => 'required|string|confirmed',
    ];

    public function changePassword()
    {
        $this->validate();
        $user = Auth::user();
        if (!Hash::check($this->currentPassword, $user->password)) {
            $this->errorMsg = "Current Password Is Incorrect";
            return;
        }
        $this->updateUserPassword($user);
        $this->clearAttributes();
    }

    public function updateUserPassword(User $user)
    {
        $user->password = Hash::make($this->password);
        $user->save();
        $this->successMsg = "Password Updated Successfully";
    }

    public function clearAttributes()
    {
        $this->currentPassword = '';
        $this->password = '';
        $this->password_confirmation = '';
    }

    public function render()
    {
        return view('livewire.auth.change-password-form');
    }
}
