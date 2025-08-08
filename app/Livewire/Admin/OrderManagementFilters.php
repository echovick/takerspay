<?php
namespace App\Livewire\Admin;

use App\Models\Order;
use Livewire\Component;
use Illuminate\Support\Facades\Response;

class OrderManagementFilters extends Component
{
    public $search = '';
    public $statusFilter = '';
    public $assetFilter = '';
    public $typeFilter = '';

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
            'assetFilter' => $this->assetFilter,
            'typeFilter' => $this->typeFilter
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

    public function updatedAssetFilter()
    {
        $this->dispatchFilters();
    }

    public function updatedTypeFilter()
    {
        $this->dispatchFilters();
    }

    public function exportOrders()
    {
        try {
            // Build query with current filters
            $query = Order::with(['user.metaData', 'assetInfo', 'wallet']);

            // Apply search filter
            if (!empty($this->search)) {
                $query->where(function ($q) {
                    $q->where('reference', 'like', '%' . $this->search . '%')
                        ->orWhere('asset', 'like', '%' . $this->search . '%')
                        ->orWhere('trade_currency', 'like', '%' . $this->search . '%')
                        ->orWhereHas('user', function ($userQuery) {
                            $userQuery->where('email', 'like', '%' . $this->search . '%');
                        })
                        ->orWhereHas('user.metaData', function ($metaQuery) {
                            $metaQuery->where('first_name', 'like', '%' . $this->search . '%')
                                ->orWhere('last_name', 'like', '%' . $this->search . '%');
                        });
                });
            }

            // Apply filters
            if ($this->statusFilter !== '' && $this->statusFilter !== 'all') {
                $query->where('transaction_status', $this->statusFilter);
            }

            if ($this->assetFilter !== '' && $this->assetFilter !== 'all') {
                $query->where('asset', $this->assetFilter);
            }

            if ($this->typeFilter !== '' && $this->typeFilter !== 'all') {
                $query->where('type', $this->typeFilter);
            }

            // Get orders for export
            $orders = $query->orderBy('created_at', 'desc')->get();

            // Generate CSV content
            $csvContent = $this->generateCsvContent($orders);

            // Create filename with timestamp
            $filename = 'orders_export_' . now()->format('Y_m_d_H_i_s') . '.csv';

            // Dispatch browser download
            $this->dispatch('downloadCsv', [
                'content' => $csvContent,
                'filename' => $filename
            ]);

            session()->flash('success', 'Orders exported successfully!');

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to export orders. Please try again.');
        }
    }

    protected function generateCsvContent($orders)
    {
        $csvData = [];
        
        // Add CSV headers
        $csvData[] = [
            'Order Reference',
            'Customer Email',
            'Customer Name',
            'Order Type',
            'Asset Type',
            'Asset Value',
            'Trade Currency',
            'Naira Amount',
            'Dollar Amount',
            'Status',
            'Created Date',
            'Confirmed Date',
            'Fulfilled Date'
        ];

        // Add order data
        foreach ($orders as $order) {
            $customerName = 'N/A';
            if ($order->user && $order->user->metaData) {
                $customerName = trim(($order->user->metaData->first_name ?? '') . ' ' . ($order->user->metaData->last_name ?? ''));
                if (empty($customerName)) {
                    $customerName = 'N/A';
                }
            }

            $csvData[] = [
                $order->reference ?? 'N/A',
                $order->user ? $order->user->email : 'N/A',
                $customerName,
                ucfirst($order->type ?? 'N/A'),
                ucfirst($order->asset ?? 'N/A'),
                $order->asset_value ?? 'N/A',
                $order->trade_currency ?? 'N/A',
                $order->naira_price ? number_format($order->naira_price, 2) : 'N/A',
                $order->dollar_price ? number_format($order->dollar_price, 2) : 'N/A',
                ucfirst($order->transaction_status ?? 'N/A'),
                $order->created_at ? $order->created_at->format('Y-m-d H:i:s') : 'N/A',
                $order->confirmed_at ? $order->confirmed_at->format('Y-m-d H:i:s') : 'N/A',
                $order->fulfilled_at ? $order->fulfilled_at->format('Y-m-d H:i:s') : 'N/A',
            ];
        }

        // Convert array to CSV string
        $output = '';
        foreach ($csvData as $row) {
            $output .= implode(',', array_map(function($field) {
                // Escape fields that contain commas, quotes, or newlines
                if (strpos($field, ',') !== false || strpos($field, '"') !== false || strpos($field, "\n") !== false) {
                    $field = '"' . str_replace('"', '""', $field) . '"';
                }
                return $field;
            }, $row)) . "\n";
        }

        return $output;
    }

    public function render()
    {
        return view('livewire.admin.order-management-filters');
    }
}