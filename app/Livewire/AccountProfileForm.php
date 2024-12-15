<?php

namespace App\Livewire;

use App\Traits\AlertMessageHelper;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AccountProfileForm extends Component
{
    use AlertMessageHelper;

    public $user;
    public $tag;
    public $email;
    public $phone;

    protected $rules = [
        'tag' => 'string',
        'email' => 'email',
        'phone' => 'string',
    ];

    public function boot()
    {
        $this->user = Auth::user();
        $this->tag = $this->user->metaData->tag;
        $this->email = $this->user->email;
        $this->phone = $this->user->phone;
    }

    public function updateProfile()
    {
        $this->validate();
        $this->user->phone = $this->phone;
        $this->user->email = $this->email;
        $this->user->metaData->tag = $this->tag;
        $this->user->save();
        $this->user->metaData->save();
        $this->setMessage('successMsg', "Profile Updated Successfully");
    }

    public function render()
    {
        return view('livewire.account-profile-form');
    }
}
