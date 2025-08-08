<?php
namespace App\Livewire\Admin;

use App\Models\Ticket;
use App\Models\TicketMessage;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class TicketStatsComponent extends Component
{
    public $totalTickets;
    public $openTickets;
    public $closedTickets;
    public $pendingTickets;
    public $ticketsToday;
    public $totalMessages;
    public $averageResponseTime;
    public $resolutionRate;

    protected $listeners = ['refreshTicketStats' => 'loadStats'];

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        // Cache ticket stats for 5 minutes for performance
        $this->totalTickets = Cache::remember('ticket_stats.total', 300, function() {
            return Ticket::count();
        });

        $this->openTickets = Cache::remember('ticket_stats.open', 300, function() {
            return Ticket::where('status', 'Open')->count();
        });

        $this->closedTickets = Cache::remember('ticket_stats.closed', 300, function() {
            return Ticket::where('status', 'Closed')->count();
        });

        $this->pendingTickets = Cache::remember('ticket_stats.pending', 300, function() {
            return Ticket::where('status', 'Pending')->count();
        });

        // Today's tickets
        $this->ticketsToday = Cache::remember('ticket_stats.today', 60, function() {
            return Ticket::whereDate('created_at', today())->count();
        });

        $this->totalMessages = Cache::remember('ticket_stats.messages', 300, function() {
            return TicketMessage::count();
        });

        // Calculate average response time (in hours)
        $this->averageResponseTime = Cache::remember('ticket_stats.response_time', 300, function() {
            $adminMessages = TicketMessage::where('is_admin', true)
                ->with('ticket')
                ->get();

            if ($adminMessages->count() === 0) {
                return 0;
            }

            $totalResponseTime = 0;
            $responseCount = 0;

            foreach ($adminMessages as $adminMessage) {
                // Find the previous user message
                $previousUserMessage = TicketMessage::where('ticket_id', $adminMessage->ticket_id)
                    ->where('is_admin', false)
                    ->where('created_at', '<', $adminMessage->created_at)
                    ->orderBy('created_at', 'desc')
                    ->first();

                if ($previousUserMessage) {
                    $responseTime = $adminMessage->created_at->diffInHours($previousUserMessage->created_at);
                    $totalResponseTime += $responseTime;
                    $responseCount++;
                }
            }

            return $responseCount > 0 ? round($totalResponseTime / $responseCount, 1) : 0;
        });

        // Calculate resolution rate
        $this->resolutionRate = Cache::remember('ticket_stats.resolution_rate', 300, function() {
            if ($this->totalTickets > 0) {
                return round(($this->closedTickets / $this->totalTickets) * 100, 1);
            }
            return 0;
        });
    }

    public function render()
    {
        return view('livewire.admin.ticket-stats-component');
    }
}