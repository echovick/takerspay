<?php
namespace App\Livewire\Admin;

use App\Http\Controllers\Admin\AppContextController;
use Illuminate\Http\Request;
use Livewire\Component;

class ContextAwareActivities extends Component
{
    public array $activities = [];
    public string $context   = 'all';

    protected $listeners = ['contextChanged' => 'updateContext'];

    public function mount()
    {
        $this->fetchActivities();
    }

    public function updateContext($context)
    {
        $this->context = $context;
        $this->fetchActivities();
    }

    protected function fetchActivities()
    {
        $request           = new Request(['context' => $this->context, 'limit' => 10]);
        $contextController = new AppContextController();
        $this->activities  = $contextController->getRecentActivities($request);
    }

    public function render()
    {
        return view('livewire.admin.context-aware-activities');
    }
}
