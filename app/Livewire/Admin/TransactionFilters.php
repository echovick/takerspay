<?php
namespace App\Livewire\Admin;

use App\Models\Transaction;
use Livewire\Component;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TransactionFilters extends Component
{
    public $search = '';
    public $statusFilter = '';
    public $typeFilter = '';
    public $dateFilter = '';
    public $customDateFrom = '';
    public $customDateTo = '';

    public function mount()
    {
        // Initialize component and dispatch initial filters
        $this->dispatchFilters();
    }

    protected function dispatchFilters()
    {
        $this->dispatch('filtersUpdated', [
            'search' => $this->search,
            'statusFilter' => $this->statusFilter,
            'typeFilter' => $this->typeFilter,
            'dateFilter' => $this->dateFilter,
            'customDateFrom' => $this->customDateFrom,
            'customDateTo' => $this->customDateTo,
        ]);
    }

    public function updatedSearch()
    {
        $this->dispatchFilters();
    }

    public function updatedStatusFilter()
    {
        $this->dispatchFilters();
    }

    public function updatedTypeFilter()
    {
        $this->dispatchFilters();
    }

    public function updatedDateFilter()
    {
        $this->dispatchFilters();
    }

    public function updatedCustomDateFrom()
    {
        $this->dispatchFilters();
    }

    public function updatedCustomDateTo()
    {
        $this->dispatchFilters();
    }

    public function exportTransactions()
    {
        try {
            $query = $this->buildTransactionQuery();
            
            return response()->streamDownload(function () use ($query) {
                $file = fopen('php://output', 'w');
                
                // CSV Headers
                fputcsv($file, [
                    'Transaction ID',
                    'Reference',
                    'User Email',
                    'Wallet Type',
                    'Type',
                    'Amount (₦)',
                    'Currency',
                    'Status',
                    'Balance Before',
                    'Balance After',
                    'Description',
                    'Date',
                    'Time'
                ]);

                // Fetch transactions in chunks to avoid memory issues
                $query->with(['wallet.user'])
                     ->orderBy('created_at', 'desc')
                     ->chunk(1000, function ($transactions) use ($file) {
                    foreach ($transactions as $transaction) {
                        $user = $transaction->wallet->user ?? null;
                        $userEmail = $user ? $user->email : 'N/A';
                        
                        fputcsv($file, [
                            $transaction->id,
                            $transaction->transaction_reference,
                            $userEmail,
                            ucfirst($transaction->wallet->type ?? 'N/A'),
                            ucfirst($transaction->transaction_type),
                            number_format($transaction->amount, 2),
                            $transaction->currency,
                            ucfirst($transaction->status),
                            number_format($transaction->balance_before ?? 0, 2),
                            number_format($transaction->balance_after ?? 0, 2),
                            $transaction->transaction_description ?? 'N/A',
                            $transaction->created_at->format('Y-m-d'),
                            $transaction->created_at->format('H:i:s')
                        ]);
                    }
                });

                fclose($file);
            }, 'transactions_' . date('Y-m-d_H-i-s') . '.csv', [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="transactions_' . date('Y-m-d_H-i-s') . '.csv"',
            ]);

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to export transactions. Please try again.');
            return null;
        }
    }

    private function buildTransactionQuery()
    {
        $query = Transaction::query();

        // Apply search filter
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('transaction_reference', 'like', '%' . $this->search . '%')
                  ->orWhere('transaction_description', 'like', '%' . $this->search . '%')
                  ->orWhere('amount', 'like', '%' . $this->search . '%')
                  ->orWhereHas('wallet.user', function ($userQuery) {
                      $userQuery->where('email', 'like', '%' . $this->search . '%');
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

        return $query;
    }

    public function render()
    {
        return view('livewire.admin.transaction-filters');
    }
}