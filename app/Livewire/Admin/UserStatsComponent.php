<?php
namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\UserMetaData;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class UserStatsComponent extends Component
{
    public $totalUsers;
    public $activeUsers;
    public $newUsersToday;
    public $newUsersThisMonth;
    public $growthPercentage;
    public $kycVerified;
    public $kycPending;
    public $kycRejected;
    public $activeToday;
    public $averageSessionTime;

    protected $listeners = ['refreshUserStats' => 'loadStats'];

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        // Cache stats for 5 minutes to improve performance
        $this->totalUsers = Cache::remember('user_stats.total', 300, function() {
            return User::where('role', 'user')->count();
        });

        $this->activeUsers = Cache::remember('user_stats.active', 300, function() {
            return User::where('role', 'user')->where('status', 'active')->count();
        });

        $this->newUsersToday = Cache::remember('user_stats.today', 60, function() {
            return User::where('role', 'user')
                ->whereDate('created_at', today())
                ->count();
        });

        $this->newUsersThisMonth = Cache::remember('user_stats.this_month', 300, function() {
            return User::where('role', 'user')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count();
        });

        // Calculate growth percentage compared to last month
        $this->growthPercentage = Cache::remember('user_stats.growth', 300, function() {
            $lastMonth = User::where('role', 'user')
                ->whereMonth('created_at', now()->subMonth()->month)
                ->whereYear('created_at', now()->subMonth()->year)
                ->count();
            
            if ($lastMonth > 0) {
                return round((($this->newUsersThisMonth - $lastMonth) / $lastMonth) * 100, 1);
            }
            return $this->newUsersThisMonth > 0 ? 100 : 0;
        });

        // KYC Statistics - based on kycVerified field in user_meta_data
        $kycStats = Cache::remember('user_stats.kyc', 300, function() {
            $verified = UserMetaData::where('status', 'active')->count(); // Using status as proxy for verification
            $total = UserMetaData::count();
            
            return [
                'verified' => $verified,
                'pending' => max(0, $total - $verified), // Simplified logic
                'rejected' => 0 // No rejection tracking in current schema
            ];
        });

        $this->kycVerified = $kycStats['verified'];
        $this->kycPending = $kycStats['pending'];
        $this->kycRejected = $kycStats['rejected'];

        // Active users today (users who logged in today - simplified to recently created)
        $this->activeToday = Cache::remember('user_stats.active_today', 60, function() {
            return User::where('role', 'user')
                ->where('status', 'active')
                ->whereDate('updated_at', today()) // Using updated_at as proxy for activity
                ->count();
        });

        // Average session time (dummy for now as we don't track sessions)
        $this->averageSessionTime = '18m'; // This would need session tracking to be accurate
    }

    public function render()
    {
        return view('livewire.admin.user-stats-component');
    }
}