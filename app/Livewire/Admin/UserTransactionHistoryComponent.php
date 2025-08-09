<?php
namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Transaction;
use Livewire\Component;
use Livewire\WithPagination;

class UserTransactionHistoryComponent extends Component
{
    use WithPagination;

    public $user;
    public $search = '';
    public $typeFilter = '';
    public $statusFilter = '';
    public $dateFilter = '';
    public $perPage = 10;
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    protected $listeners = ['refreshTransactions' => '$refresh'];

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function sortBy($field)
    {
        // Map frontend field names to database column names
        $fieldMapping = [
            'reference' => 'transaction_reference',
            'type' => 'transaction_type',
            'description' => 'transaction_description',
            'amount' => 'amount',
            'created_at' => 'created_at'
        ];
        
        $dbField = $fieldMapping[$field] ?? $field;
        
        if ($this->sortBy === $dbField) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $dbField;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedTypeFilter()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function updatedDateFilter()
    {
        $this->resetPage();
    }

    public function getTransactions()
    {
        $query = Transaction::whereHas('wallet', function ($q) {
            $q->where('user_id', $this->user->id);
        })->with(['wallet']);

        // Apply search filter
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('transaction_reference', 'like', '%' . $this->search . '%')
                  ->orWhere('transaction_description', 'like', '%' . $this->search . '%');
            });
        }

        // Apply type filter
        if ($this->typeFilter !== '' && $this->typeFilter !== 'all') {
            $query->where('transaction_type', $this->typeFilter);
        }

        // Apply status filter
        if ($this->statusFilter !== '' && $this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
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
            }
        }

        // Apply sorting
        $query->orderBy($this->sortBy, $this->sortDirection);

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

    public function render()
    {
        $transactions = $this->getTransactions();
        
        return view('livewire.admin.user-transaction-history-component', [
            'transactions' => $transactions
        ]);
    }
}