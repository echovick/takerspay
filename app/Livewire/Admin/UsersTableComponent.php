<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;

class UsersTableComponent extends Component
{
    public $users;

    public function mount()
    {
        $this->users = User::where('role', 'user')->get();
    }

    public function render()
    {
        return view('livewire.admin.users-table-component');
    }
}
