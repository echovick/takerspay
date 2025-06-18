<?php
namespace App\Livewire\Admin;

use App\Http\Controllers\Admin\AppContextController;
use Illuminate\Http\Request;
use Livewire\Component;

class ContextAwareStats extends Component
{
    public array $stats    = [];
    public string $context = 'all';

    protected $listeners = ['contextChanged' => 'updateContext'];

    public function mount()
    {
        $this->fetchStats();
    }

    public function updateContext($context)
    {
        $this->context = $context;
        $this->fetchStats();
    }

    protected function fetchStats()
    {
        $request           = new Request(['context' => $this->context]);
        $contextController = new AppContextController();
        $this->stats       = $contextController->getContextStats($request);
    }

    public function render()
    {
        return view('livewire.admin.context-aware-stats');
    }
}
