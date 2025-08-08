<?php
namespace App\Livewire\Admin;

use App\Models\Order;
use App\Models\Asset;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class OrderStatsComponent extends Component
{
    public $totalOrders;
    public $pendingOrders;
    public $completedOrders;
    public $processingOrders;
    public $canceledOrders;
    public $todaysOrders;
    public $totalValue;
    public $averageOrderValue;
    public $cryptoOrders;
    public $giftcardOrders;
    public $buyOrders;
    public $sellOrders;

    protected $listeners = ['refreshOrderStats' => 'loadStats'];

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        // Cache order stats for 5 minutes for performance
        $this->totalOrders = Cache::remember('order_stats.total', 300, function() {
            return Order::count();
        });

        $this->pendingOrders = Cache::remember('order_stats.pending', 300, function() {
            return Order::where('transaction_status', 'pending')->count();
        });

        $this->completedOrders = Cache::remember('order_stats.completed', 300, function() {
            return Order::where('transaction_status', 'completed')->count();
        });

        $this->processingOrders = Cache::remember('order_stats.processing', 300, function() {
            return Order::whereIn('transaction_status', ['processing', 'confirmed'])->count();
        });

        $this->canceledOrders = Cache::remember('order_stats.canceled', 300, function() {
            return Order::where('transaction_status', 'canceled')->count();
        });

        $this->todaysOrders = Cache::remember('order_stats.today', 60, function() {
            return Order::whereDate('created_at', today())->count();
        });

        // Calculate total order value and average
        $orderValues = Cache::remember('order_stats.values', 300, function() {
            $totalValue = Order::where('transaction_status', 'completed')
                ->sum('naira_price');
            
            $completedCount = Order::where('transaction_status', 'completed')->count();
            $averageValue = $completedCount > 0 ? $totalValue / $completedCount : 0;

            return [
                'total' => $totalValue,
                'average' => $averageValue
            ];
        });

        $this->totalValue = $orderValues['total'];
        $this->averageOrderValue = $orderValues['average'];

        // Asset type breakdown
        $assetBreakdown = Cache::remember('order_stats.assets', 300, function() {
            return [
                'crypto' => Order::where('asset', 'crypto')->count(),
                'giftcard' => Order::where('asset', 'giftcard')->count(),
            ];
        });

        $this->cryptoOrders = $assetBreakdown['crypto'];
        $this->giftcardOrders = $assetBreakdown['giftcard'];

        // Order type breakdown
        $typeBreakdown = Cache::remember('order_stats.types', 300, function() {
            return [
                'buy' => Order::where('type', 'buy')->count(),
                'sell' => Order::where('type', 'sell')->count(),
            ];
        });

        $this->buyOrders = $typeBreakdown['buy'];
        $this->sellOrders = $typeBreakdown['sell'];
    }

    public function render()
    {
        return view('livewire.admin.order-stats-component');
    }
}