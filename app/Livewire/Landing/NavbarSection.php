<?php
namespace App\Livewire\Landing;

use Livewire\Component;

class NavbarSection extends Component
{
    public $isOpen = false;

    public $menuItems = [
        ['name' => 'Home', 'route' => '/', 'active' => true],
        ['name' => 'Features', 'route' => '#features', 'active' => false],
        ['name' => 'About Us', 'route' => '#about', 'active' => false],
        ['name' => 'Contact', 'route' => '#contact', 'active' => false],
    ];

    public function mount()
    {
        $this->isOpen = false;
    }

    public function toggleMenu()
    {
        $this->isOpen = ! $this->isOpen;
    }

    public function render()
    {
        return view('livewire.landing.navbar-section');
    }
}
