<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use App\Models\User;
use Livewire\Component;

class DashboardStats extends Component
{
    public $totalUsers;
    public $pendingOrders;
    public $completedOrders;
    public $totalSales;
    public $totalRevenue;

    public function mount()
    {
        $this->totalUsers = $this->getTotalUsers();
        $this->pendingOrders = $this->getPendingOrders();
        $this->completedOrders = $this->getCompletedOrders();
        $this->totalRevenue = $this->getTotalRevenue();
    }

    protected function getTotalUsers()
    {
        return User::count();
    }

    protected function getPendingOrders ()
    {
        return Order::where('transaction_status', 'pending')->orWhere('transaction_status', 'confirmed')->count();
    }

    protected function getCompletedOrders()
    {
        return Order::where('transaction_status', 'completed')->count();
    }

    protected function getTotalSales()
    {
        return Order::count();
    }

    protected function getTotalRevenue()
    {
        return Order::sum('naira_price');
    }
    public function render()
    {
        return view('livewire.admin.dashboard-stats');
    }
}
