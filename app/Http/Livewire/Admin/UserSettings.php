<?php
namespace App\Http\Livewire\Admin;

use App\Models\User;
use App\Models\UserMetaData;
use Livewire\Component;

class UserSettings extends Component
{
    public $user;
    public $firstName;
    public $lastName;
    public $email;
    public $phone;
    public $address;
    public $city;
    public $state;
    public $country;
    public $kycStatus;
    public $successMessage;
    public $errorMessage;

    protected $rules = [
        'firstName' => 'nullable|string|max:255',
        'lastName'  => 'nullable|string|max:255',
        'email'     => 'required|email|max:255',
        'phone'     => 'nullable|string|max:20',
        'address'   => 'nullable|string|max:255',
        'city'      => 'nullable|string|max:100',
        'state'     => 'nullable|string|max:100',
        'country'   => 'nullable|string|max:100',
        'kycStatus' => 'nullable|string|in:Verified,Pending,Not Verified',
    ];

    public function mount(User $user)
    {
        $this->user = $user;
        $this->loadUserData();
    }

    public function loadUserData()
    {
        $this->firstName = $this->user->metaData->first_name ?? '';
        $this->lastName  = $this->user->metaData->last_name ?? '';
        $this->email     = $this->user->email;
        $this->phone     = $this->user->phone ?? '';
        $this->address   = $this->user->metaData->address ?? '';
        $this->city      = $this->user->metaData->city ?? '';
        $this->state     = $this->user->metaData->state ?? '';
        $this->country   = $this->user->metaData->country ?? '';
        $this->kycStatus = $this->user->metaData->kycVerified ?? 'Not Verified';
    }

    public function updateProfile()
    {
        $validatedData = $this->validate();

        try {
            // Update user email
            $this->user->email = $validatedData['email'];
            $this->user->phone = $validatedData['phone'];
            $this->user->save();

            // Update or create user metadata
            $metaData              = $this->user->metaData ?? new UserMetaData();
            $metaData->user_id     = $this->user->id;
            $metaData->first_name  = $validatedData['firstName'];
            $metaData->last_name   = $validatedData['lastName'];
            $metaData->address     = $validatedData['address'];
            $metaData->city        = $validatedData['city'];
            $metaData->state       = $validatedData['state'];
            $metaData->country     = $validatedData['country'];
            $metaData->kycVerified = $validatedData['kycStatus'];
            $metaData->save();

            $this->successMessage = 'User profile updated successfully.';
            $this->errorMessage   = '';
        } catch (\Exception $e) {
            $this->errorMessage   = 'Error updating profile: ' . $e->getMessage();
            $this->successMessage = '';
        }
    }

    public function updateKycStatus($status)
    {
        if (! in_array($status, ['Verified', 'Pending', 'Not Verified'])) {
            $this->errorMessage = 'Invalid KYC status.';
            return;
        }

        try {
            $metaData              = $this->user->metaData ?? new UserMetaData();
            $metaData->user_id     = $this->user->id;
            $metaData->kycVerified = $status;
            $metaData->save();

            $this->kycStatus      = $status;
            $this->successMessage = 'KYC status updated successfully.';
            $this->errorMessage   = '';
        } catch (\Exception $e) {
            $this->errorMessage   = 'Error updating KYC status: ' . $e->getMessage();
            $this->successMessage = '';
        }
    }

    public function render()
    {
        return view('livewire.admin.user-settings');
    }
}
