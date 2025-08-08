<?php
namespace App\Livewire\Admin;

use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class TicketsTableComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $dateFilter = '';
    public $perPage = 10;
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    
    // Ticket Response Modal Properties
    public $showResponseModal = false;
    public $selectedTicket = null;
    public $responseMessage = '';
    public $newStatus = '';

    // View Ticket Modal Properties
    public $showViewModal = false;
    public $viewTicket = null;

    protected $listeners = ['filtersUpdated' => 'updateFilters', 'refreshTickets' => '$refresh'];

    public function mount()
    {
        // Initialize component
    }

    public function updateFilters($filters)
    {
        $this->search = $filters['search'] ?? '';
        $this->statusFilter = $filters['statusFilter'] ?? '';
        $this->dateFilter = $filters['dateFilter'] ?? '';
        $this->sortBy = $filters['sortBy'] ?? 'created_at';
        $this->sortDirection = $filters['sortDirection'] ?? 'desc';
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

    public function getTickets()
    {
        $query = Ticket::with(['user.metaData', 'messages']);

        // Apply search filter
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('subject', 'like', '%' . $this->search . '%')
                  ->orWhere('last_message', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', function ($userQuery) {
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
        if ($this->sortBy === 'user_name') {
            $query->join('users', 'tickets.user_id', '=', 'users.id')
                  ->leftJoin('user_meta_data', 'users.id', '=', 'user_meta_data.user_id')
                  ->orderBy('user_meta_data.first_name', $this->sortDirection)
                  ->select('tickets.*');
        } else {
            $query->orderBy($this->sortBy, $this->sortDirection);
        }

        return $query->paginate($this->perPage);
    }

    public function openResponseModal($ticketId)
    {
        $this->selectedTicket = Ticket::with(['user.metaData', 'messages.user.metaData'])->findOrFail($ticketId);
        $this->newStatus = $this->selectedTicket->status;
        $this->showResponseModal = true;
        $this->resetResponseForm();
    }

    public function closeResponseModal()
    {
        $this->showResponseModal = false;
        $this->selectedTicket = null;
        $this->resetResponseForm();
    }

    public function openViewModal($ticketId)
    {
        $this->viewTicket = Ticket::with(['user.metaData', 'messages.user.metaData'])->findOrFail($ticketId);
        $this->showViewModal = true;
    }

    public function closeViewModal()
    {
        $this->showViewModal = false;
        $this->viewTicket = null;
    }

    protected function resetResponseForm()
    {
        $this->responseMessage = '';
        $this->resetValidation();
    }

    public function updateTicketStatus($ticketId, $status)
    {
        try {
            $ticket = Ticket::findOrFail($ticketId);
            $ticket->update(['status' => $status]);

            $this->dispatch('refreshTicketStats');
            $this->clearTicketCache();

            session()->flash('success', "Ticket status updated to {$status}");
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update ticket status.');
        }
    }

    public function sendResponse()
    {
        $this->validate([
            'responseMessage' => 'required|string|min:10',
            'newStatus' => 'required|in:Open,Pending,Closed',
        ], [], [
            'responseMessage' => 'Response Message',
            'newStatus' => 'Status',
        ]);

        try {
            $ticket = $this->selectedTicket;
            
            // Create the response message
            $ticket->messages()->create([
                'user_id' => Auth::id(),
                'message' => $this->responseMessage,
                'is_admin' => true,
            ]);

            // Update ticket status and last message
            $ticket->update([
                'status' => $this->newStatus,
                'last_message' => $this->responseMessage,
            ]);

            // Close modal
            $this->closeResponseModal();

            // Refresh stats
            $this->dispatch('refreshTicketStats');
            $this->clearTicketCache();

            session()->flash('success', 'Response sent and ticket updated successfully!');

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to send response. Please try again.');
        }
    }

    public function getStatusColor($status)
    {
        return match($status) {
            'Open' => 'bg-red-100 text-red-800',
            'Pending' => 'bg-yellow-100 text-yellow-800',
            'Closed' => 'bg-green-100 text-green-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getStatusDotColor($status)
    {
        return match($status) {
            'Open' => 'bg-red-500',
            'Pending' => 'bg-yellow-500',
            'Closed' => 'bg-green-500',
            default => 'bg-gray-500',
        };
    }

    public function getPriorityColor($messageCount)
    {
        // Simple priority based on message count
        if ($messageCount > 10) return 'text-red-600'; // High priority
        if ($messageCount > 5) return 'text-orange-600'; // Medium priority
        return 'text-green-600'; // Low priority
    }

    private function clearTicketCache()
    {
        \Illuminate\Support\Facades\Cache::forget('ticket_stats.total');
        \Illuminate\Support\Facades\Cache::forget('ticket_stats.open');
        \Illuminate\Support\Facades\Cache::forget('ticket_stats.closed');
        \Illuminate\Support\Facades\Cache::forget('ticket_stats.pending');
        \Illuminate\Support\Facades\Cache::forget('ticket_stats.messages');
        \Illuminate\Support\Facades\Cache::forget('ticket_stats.response_time');
        \Illuminate\Support\Facades\Cache::forget('ticket_stats.resolution_rate');
    }

    public function render()
    {
        $tickets = $this->getTickets();
        
        return view('livewire.admin.tickets-table-component', [
            'tickets' => $tickets,
        ]);
    }
}