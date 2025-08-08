<?php
namespace App\Livewire\Admin;

use App\Models\Asset;
use App\Models\Order;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class AssetStatsComponent extends Component
{
    public $totalAssets;
    public $cryptoAssets;
    public $giftcardAssets;
    public $activeAssets;
    public $totalOrders;
    public $averageBuyRate;
    public $averageSellRate;
    public $topPerformingAsset;
    public $recentlyAddedAssets;
    public $ordersToday;

    protected $listeners = ['refreshAssetStats' => 'loadStats'];

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        // Cache asset stats for 5 minutes for performance
        $this->totalAssets = Cache::remember('asset_stats.total', 300, function() {
            return Asset::count();
        });

        $this->cryptoAssets = Cache::remember('asset_stats.crypto', 300, function() {
            return Asset::where('type', 'crypto')->count();
        });

        $this->giftcardAssets = Cache::remember('asset_stats.giftcard', 300, function() {
            return Asset::where('type', 'giftcard')->count();
        });

        $this->activeAssets = Cache::remember('asset_stats.active', 300, function() {
            return Asset::where('available_units', '>', 0)->count();
        });

        $this->totalOrders = Cache::remember('asset_stats.orders', 300, function() {
            return Order::whereNotNull('asset_id')->count();
        });

        // Calculate average rates
        $rateStats = Cache::remember('asset_stats.rates', 300, function() {
            $avgBuyRate = Asset::where('naira_buy_rate', '>', 0)->avg('naira_buy_rate');
            $avgSellRate = Asset::where('naira_sell_rate', '>', 0)->avg('naira_sell_rate');
            
            return [
                'buy' => $avgBuyRate ?? 0,
                'sell' => $avgSellRate ?? 0
            ];
        });

        $this->averageBuyRate = $rateStats['buy'];
        $this->averageSellRate = $rateStats['sell'];

        // Get top performing asset (most orders)
        $this->topPerformingAsset = Cache::remember('asset_stats.top_asset', 300, function() {
            $topAssetId = Order::select('asset_id')
                ->whereNotNull('asset_id')
                ->groupBy('asset_id')
                ->orderByRaw('COUNT(*) DESC')
                ->first()?->asset_id;

            if ($topAssetId) {
                $asset = Asset::find($topAssetId);
                return $asset ? $asset->name : 'N/A';
            }
            return 'N/A';
        });

        // Recently added assets (last 7 days)
        $this->recentlyAddedAssets = Cache::remember('asset_stats.recent', 300, function() {
            return Asset::where('created_at', '>=', now()->subDays(7))->count();
        });

        // Orders created today
        $this->ordersToday = Cache::remember('asset_stats.orders_today', 60, function() {
            return Order::whereDate('created_at', today())
                ->whereNotNull('asset_id')
                ->count();
        });
    }

    public function render()
    {
        return view('livewire.admin.asset-stats-component');
    }
}