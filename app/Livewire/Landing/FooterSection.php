<?php
namespace App\Livewire\Landing;

use Livewire\Component;

class FooterSection extends Component
{
    public $footerLinks = [
        [
            'title' => 'Company',
            'links' => [
                ['name' => 'About', 'href' => '#'],
                ['name' => 'Careers', 'href' => '#'],
                ['name' => 'Blog', 'href' => '#'],
                ['name' => 'Press', 'href' => '#'],
            ],
        ],
        [
            'title' => 'Support',
            'links' => [
                ['name' => 'Help Center', 'href' => '#'],
                ['name' => 'Contact Us', 'href' => '#'],
                ['name' => 'FAQs', 'href' => '#'],
                ['name' => 'Community', 'href' => '#'],
            ],
        ],
        [
            'title' => 'Legal',
            'links' => [
                ['name' => 'Privacy Policy', 'href' => '#'],
                ['name' => 'Terms of Service', 'href' => '#'],
                ['name' => 'Cookie Policy', 'href' => '#'],
            ],
        ],
    ];

    public function render()
    {
        return view('livewire.landing.footer-section');
    }
}
