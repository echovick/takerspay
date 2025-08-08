<?php
namespace App\Livewire\Admin;

use App\Models\Transaction;
use Livewire\Component;
use Livewire\WithPagination;

class TransactionsTableComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $typeFilter = '';
    public $dateFilter = '';
    public $customDateFrom = '';
    public $customDateTo = '';
    public $perPage = 10;
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    protected $listeners = ['filtersUpdated' => 'updateFilters', 'refreshTransactions' => '$refresh'];

    public function mount()
    {
        // Initialize component
    }

    public function updateFilters($filters)
    {
        $this->search = $filters['search'] ?? '';
        $this->statusFilter = $filters['statusFilter'] ?? '';
        $this->typeFilter = $filters['typeFilter'] ?? '';
        $this->dateFilter = $filters['dateFilter'] ?? '';
        $this->customDateFrom = $filters['customDateFrom'] ?? '';
        $this->customDateTo = $filters['customDateTo'] ?? '';
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

    public function getTransactions()
    {
        $query = Transaction::with(['wallet.user.metaData', 'wallet.asset']);

        // Apply search filter
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('transaction_reference', 'like', '%' . $this->search . '%')
                  ->orWhere('transaction_description', 'like', '%' . $this->search . '%')
                  ->orWhere('amount', 'like', '%' . $this->search . '%')
                  ->orWhereHas('wallet.user', function ($userQuery) {
                      $userQuery->where('email', 'like', '%' . $this->search . '%')
                               ->orWhereHas('metaData', function ($metaQuery) {
                                   $metaQuery->where('first_name', 'like', '%' . $this->search . '%')
                                            ->orWhere('last_name', 'like', '%' . $this->search . '%');
                               });
                  });
            });
        }

        // Apply status filter
        if ($this->statusFilter !== '' && $this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        // Apply type filter
        if ($this->typeFilter !== '' && $this->typeFilter !== 'all') {
            $query->where('transaction_type', $this->typeFilter);
        }

        // Apply date filter
        if ($this->dateFilter !== '' && $this->dateFilter !== 'all') {
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
                case 'custom':
                    if ($this->customDateFrom) {
                        $query->whereDate('created_at', '>=', $this->customDateFrom);
                    }
                    if ($this->customDateTo) {
                        $query->whereDate('created_at', '<=', $this->customDateTo);
                    }
                    break;
            }
        }

        // Apply sorting
        if ($this->sortBy === 'user_email') {
            $query->join('wallets', 'transactions.wallet_id', '=', 'wallets.id')
                  ->join('users', 'wallets.user_id', '=', 'users.id')
                  ->orderBy('users.email', $this->sortDirection)
                  ->select('transactions.*');
        } else {
            $query->orderBy($this->sortBy, $this->sortDirection);
        }

        return $query->paginate($this->perPage);
    }

    public function getStatusColor($status)
    {
        return match($status) {
            'completed' => 'bg-green-100 text-green-800',
            'pending' => 'bg-yellow-100 text-yellow-800',
            'failed' => 'bg-red-100 text-red-800',
            'cancelled' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getStatusDotColor($status)
    {
        return match($status) {
            'completed' => 'bg-green-500',
            'pending' => 'bg-yellow-500',
            'failed' => 'bg-red-500',
            'cancelled' => 'bg-gray-500',
            default => 'bg-gray-500',
        };
    }

    public function getTypeColor($type)
    {
        return match($type) {
            'credit' => 'text-green-600',
            'debit' => 'text-red-600',
            default => 'text-gray-600',
        };
    }

    public function getTypeIcon($type)
    {
        return match($type) {
            'credit' => 'M12 9v3m0 0v3m0-3h3m-3 0H9',
            'debit' => 'M15 12H9',
            default => 'M12 9v3m0 0v3m0-3h3m-3 0H9',
        };
    }

    public function render()
    {
        $transactions = $this->getTransactions();
        
        return view('livewire.admin.transactions-table-component', [
            'transactions' => $transactions,
        ]);
    }
}