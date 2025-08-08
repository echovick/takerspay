<?php
namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UsersTableComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = 'all';
    public $dateFilter = 'all';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 10;
    
    protected $listeners = ['refreshUsers' => '$refresh', 'filtersUpdated' => 'updateFilters'];

    public function mount()
    {
        // Initialize component
    }

    public function updateFilters($filters)
    {
        $this->search = $filters['search'] ?? '';
        $this->statusFilter = $filters['statusFilter'] ?? 'all';
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingDateFilter()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function getUsers()
    {
        $query = User::where('role', 'user')
            ->with(['metaData', 'wallets', 'orders']);

        // Apply search filter
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('email', 'like', '%' . $this->search . '%')
                    ->orWhere('phone', 'like', '%' . $this->search . '%')
                    ->orWhereHas('metaData', function ($metaQuery) {
                        $metaQuery->where('first_name', 'like', '%' . $this->search . '%')
                            ->orWhere('last_name', 'like', '%' . $this->search . '%')
                            ->orWhere('tag', 'like', '%' . $this->search . '%');
                    });
            });
        }

        // Apply status filter
        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        // Apply date filter
        if ($this->dateFilter !== 'all') {
            switch ($this->dateFilter) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;
                case 'week':
                    $query->where('created_at', '>=', now()->subWeek());
                    break;
                case 'month':
                    $query->where('created_at', '>=', now()->subMonth());
                    break;
                case 'year':
                    $query->where('created_at', '>=', now()->subYear());
                    break;
            }
        }

        // Apply sorting
        if ($this->sortBy === 'name') {
            $query->leftJoin('user_meta_data', 'users.id', '=', 'user_meta_data.user_id')
                ->orderBy('user_meta_data.first_name', $this->sortDirection);
        } elseif ($this->sortBy === 'balance') {
            // We'll handle balance sorting in the collection after loading
            $users = $query->get();
            $users->each(function ($user) {
                $user->account_balance = $this->calculateUserBalance($user);
            });
            
            $users = $users->sortBy([
                ['account_balance', $this->sortDirection]
            ]);
            
            // Manual pagination for balance sorting
            $currentPage = request()->get('page', 1);
            $items = $users->forPage($currentPage, $this->perPage);
            
            return new \Illuminate\Pagination\LengthAwarePaginator(
                $items,
                $users->count(),
                $this->perPage,
                $currentPage,
                ['path' => request()->url()]
            );
        } else {
            $query->orderBy($this->sortBy, $this->sortDirection);
        }

        $users = $query->paginate($this->perPage);

        // Calculate account balance for each user
        $users->getCollection()->transform(function ($user) {
            $user->account_balance = $this->calculateUserBalance($user);
            $user->orders_count = $user->orders->count();
            $user->wallets_count = $user->wallets->count();
            return $user;
        });

        return $users;
    }

    /**
     * Calculate the total balance for a user from all their wallets
     */
    protected function calculateUserBalance(User $user)
    {
        return $user->wallets->sum('balance');
    }

    /**
     * Get user status with proper formatting
     */
    public function getUserStatus(User $user)
    {
        $status = $user->status ?? 'active';
        
        return [
            'status' => $status,
            'color' => match($status) {
                'active' => 'green',
                'inactive' => 'gray',
                'suspended' => 'red',
                'pending' => 'yellow',
                default => 'blue'
            }
        ];
    }

    /**
     * Get KYC verification status
     */
    public function getKYCStatus(User $user)
    {
        $kycStatus = $user->metaData?->kycVerified ?? 'Not Verified';
        
        return [
            'status' => $kycStatus,
            'color' => match($kycStatus) {
                'Verified' => 'green',
                'Pending' => 'yellow',
                'Rejected' => 'red',
                default => 'gray'
            }
        ];
    }

    public function render()
    {
        $users = $this->getUsers();
        
        return view('livewire.admin.users-table-component', [
            'users' => $users,
        ]);
    }
}
