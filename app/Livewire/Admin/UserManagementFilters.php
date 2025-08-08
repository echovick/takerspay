<?php
namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\UserMetaData;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

class UserManagementFilters extends Component
{
    public $search = '';
    public $statusFilter = '';
    public $showAddUserModal = false;
    
    // Add User Form Properties
    public $email = '';
    public $phone = '';
    public $password = '';
    public $password_confirmation = '';
    public $role = 'user';
    public $status = 'active';
    public $first_name = '';
    public $last_name = '';
    public $middle_name = '';
    public $tag = '';
    public $gender = '';
    public $date_of_birth = '';
    public $address = '';

    protected $listeners = ['refreshFilters' => '$refresh'];

    public function mount()
    {
        // Initialize component
    }

    public function updatedSearch()
    {
        $this->dispatch('filtersUpdated', [
            'search' => $this->search,
            'statusFilter' => $this->statusFilter
        ]);
    }

    public function updatedStatusFilter()
    {
        $this->dispatch('filtersUpdated', [
            'search' => $this->search,
            'statusFilter' => $this->statusFilter
        ]);
    }

    public function openAddUserModal()
    {
        $this->showAddUserModal = true;
        $this->resetForm();
    }

    public function closeAddUserModal()
    {
        $this->showAddUserModal = false;
        $this->resetForm();
    }

    protected function resetForm()
    {
        $this->email = '';
        $this->phone = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->role = 'user';
        $this->status = 'active';
        $this->first_name = '';
        $this->last_name = '';
        $this->middle_name = '';
        $this->tag = '';
        $this->gender = '';
        $this->date_of_birth = '';
        $this->address = '';
        $this->resetValidation();
    }

    protected function rules()
    {
        return [
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
            'role' => 'required|in:user,admin',
            'status' => 'required|in:active,inactive,suspended,pending',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'tag' => 'nullable|string|max:50|unique:user_meta_data,tag',
            'gender' => 'nullable|in:male,female,other',
            'date_of_birth' => 'nullable|date|before:today',
            'address' => 'nullable|string|max:500',
        ];
    }

    protected function validationAttributes()
    {
        return [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'middle_name' => 'Middle Name',
            'date_of_birth' => 'Date of Birth',
        ];
    }

    public function createUser()
    {
        $this->validate();

        try {
            // Create the user
            $user = User::create([
                'email' => $this->email,
                'phone' => $this->phone,
                'password' => Hash::make($this->password),
                'role' => $this->role,
                'status' => $this->status,
            ]);

            // Create user metadata
            UserMetaData::create([
                'user_id' => $user->id,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'middle_name' => $this->middle_name,
                'tag' => $this->tag ?: null,
                'gender' => $this->gender ?: null,
                'date_of_birth' => $this->date_of_birth ?: null,
                'address' => $this->address ?: null,
                'phone_number' => $this->phone,
                'status' => 'active', // Default status for metadata
            ]);

            // Close modal and reset form
            $this->closeAddUserModal();

            // Refresh the users table and stats
            $this->dispatch('refreshUsers');
            $this->dispatch('refreshUserStats');

            // Clear cache to ensure fresh data
            \Illuminate\Support\Facades\Cache::forget('user_stats.total');
            \Illuminate\Support\Facades\Cache::forget('user_stats.active');
            \Illuminate\Support\Facades\Cache::forget('user_stats.today');
            \Illuminate\Support\Facades\Cache::forget('user_stats.this_month');
            \Illuminate\Support\Facades\Cache::forget('user_stats.growth');
            \Illuminate\Support\Facades\Cache::forget('user_stats.kyc');
            \Illuminate\Support\Facades\Cache::forget('user_stats.active_today');

            // Show success message
            session()->flash('success', 'User created successfully!');

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to create user. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.admin.user-management-filters');
    }
}