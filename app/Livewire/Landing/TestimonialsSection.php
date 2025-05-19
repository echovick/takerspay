<?php
namespace App\Livewire\Landing;

use Livewire\Component;

class TestimonialsSection extends Component
{
    public $testimonials = [
        [
            'content' => 'TakersPay has completely transformed how I trade crypto and gift cards. Their platform is incredibly intuitive and transactions are lightning-fast!',
            'author'  => 'Adebayo Johnson',
            'role'    => 'Crypto Enthusiast',
        ],
        [
            'content' => 'As a frequent gift card trader, I\'ve tried many platforms, but TakersPay stands out with their competitive rates and excellent customer service.',
            'author'  => 'Chioma Okonkwo',
            'role'    => 'Business Owner',
        ],
        [
            'content' => 'The security features on TakersPay give me peace of mind. I never worry about my transactions or personal information.',
            'author'  => 'Emmanuel Olatunji',
            'role'    => 'Regular Trader',
        ],
    ];

    public function render()
    {
        return view('livewire.landing.testimonials-section');
    }
}
