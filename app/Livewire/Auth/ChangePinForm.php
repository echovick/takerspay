<?php

namespace App\Livewire\Auth;

use App\Services\PinService;
use App\Traits\AlertMessageHelper;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChangePinForm extends Component
{
    use AlertMessageHelper;

    public $pin;
    public $pin1;
    public $pin2;
    public $pin3;
    public $pin4;
    public $pin5;
    public $pin6;

    protected PinService $pinService;

    protected $rules = [
        'pin' => 'required|numeric|digits:6',
    ];

    public function boot(PinService $pinService)
    {
        $this->pinService = $pinService;
    }

    public function changePin()
    {
        $this->pin = $this->pin1.$this->pin2.$this->pin3.$this->pin4.$this->pin5.$this->pin6;
        $this->validate();
        $user = Auth::user();
        if (isset($user->pin)) {
            $user->pin->pin = $this->pin;
            $user->pin->save();
            $this->setMessage("successMsg", "Pin Updated Successfully");
        } else {
            $this->pinService->newUserPin($user, $this->pin);
            $this->setMessage("successMsg", "Pin Created Successfully");
        }
    }

    public function render()
    {
        return view('livewire.auth.change-pin-form');
    }
}
