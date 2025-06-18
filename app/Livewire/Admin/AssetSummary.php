<?php
namespace App\Livewire\Admin;

use App\Models\Asset;
use Livewire\Component;

class AssetSummary extends Component
{
    public array $assets = [];

    public function mount()
    {
        $this->loadAssets();
    }

    protected function loadAssets()
    {
        $this->assets = Asset::orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.admin.asset-summary');
    }
}
