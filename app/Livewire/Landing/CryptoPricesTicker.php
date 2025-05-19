<?php
namespace App\Livewire\Landing;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class CryptoPricesTicker extends Component
{
    public $prices  = [];
    public $loading = true;
    public $error   = false;

    public function mount()
    {
        $this->fetchPrices();
    }

    public function fetchPrices()
    {
        try {
            $response = Http::get('https://api.coingecko.com/api/v3/simple/price', [
                'ids'           => 'bitcoin,ethereum,binancecoin,solana,ripple,cardano',
                'vs_currencies' => 'usd',
            ]);

            if ($response->successful()) {
                $this->prices  = $response->json();
                $this->loading = false;
            } else {
                Log::error('Error fetching crypto prices: ' . $response->body());
                $this->error   = true;
                $this->loading = false;
            }
        } catch (\Exception $e) {
            Log::error('Error fetching crypto prices: ' . $e->getMessage());
            $this->error   = true;
            $this->loading = false;
        }
    }

    public function render()
    {
        return view('livewire.landing.crypto-prices-ticker');
    }
}
