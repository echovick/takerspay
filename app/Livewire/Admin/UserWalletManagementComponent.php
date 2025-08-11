<?php
namespace App\Livewire\Admin;

use App\Models\BankAccount;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class UserWalletManagementComponent extends Component
{
    public $user;

    // Modal states
    public $showDepositModal  = false;
    public $showWithdrawModal = false;
    public $showTransferModal = false;

    // Deposit form
    public $depositWalletType  = 'nuban';
    public $depositAmount      = '';
    public $depositDescription = '';

    // Withdraw form
    public $withdrawWalletType    = 'nuban';
    public $withdrawAmount        = '';
    public $withdrawBankAccount   = '';
    public $withdrawDescription   = '';
    public $availableBankAccounts = [];

    // Transfer form
    public $transferFromWalletType = 'nuban';
    public $transferToUserId       = '';
    public $transferToWalletType   = 'nuban';
    public $transferAmount         = '';
    public $transferDescription    = '';
    public $searchUsers            = [];
    public $userSearchTerm         = '';

    protected $listeners = ['refreshWallets' => '$refresh'];

    public function mount(User $user)
    {
        $this->user = $user;
        $this->loadBankAccounts();
    }

    public function loadBankAccounts()
    {
        $this->availableBankAccounts = BankAccount::where('user_id', $this->user->id)
            ->where('status', 'active')
            ->get()
            ->map(function ($account) {
                return [
                    'id'      => $account->id,
                    'display' => $account->bank_name . ' - ' . $account->account_number . ' (' . $account->account_name . ')',
                ];
            })
            ->toArray();
    }

    public function searchUsersForTransfer()
    {
        if (strlen($this->userSearchTerm) >= 2) {
            $this->searchUsers = User::where('role', 'user')
                ->where('id', '!=', $this->user->id)
                ->where(function ($query) {
                    $query->where('email', 'like', '%' . $this->userSearchTerm . '%')
                        ->orWhereHas('metaData', function ($q) {
                            $q->where('first_name', 'like', '%' . $this->userSearchTerm . '%')
                                ->orWhere('last_name', 'like', '%' . $this->userSearchTerm . '%');
                        });
                })
                ->limit(10)
                ->get()
                ->map(function ($user) {
                    $name = trim(($user->metaData->first_name ?? '') . ' ' . ($user->metaData->last_name ?? ''));
                    return [
                        'id'      => $user->id,
                        'display' => $name ?: $user->email,
                        'email'   => $user->email,
                    ];
                })
                ->toArray();
        } else {
            $this->searchUsers = [];
        }
    }

    public function selectTransferUser($userId)
    {
        $this->transferToUserId = $userId;
        $this->userSearchTerm   = collect($this->searchUsers)->firstWhere('id', $userId)['display'] ?? '';
        $this->searchUsers      = [];
    }

    // Deposit Methods
    public function openDepositModal()
    {
        $this->showDepositModal = true;
        $this->resetDepositForm();
    }

    public function closeDepositModal()
    {
        $this->showDepositModal = false;
        $this->resetDepositForm();
    }

    public function resetDepositForm()
    {
        $this->depositAmount      = '';
        $this->depositDescription = '';
        $this->resetValidation();
    }

    public function processDeposit()
    {
        $this->validate([
            'depositAmount'      => 'required|numeric|min:0.01|max:1000000',
            'depositWalletType'  => 'required|in:nuban',
            'depositDescription' => 'required|string|min:5|max:255',
        ], [], [
            'depositAmount'      => 'Amount',
            'depositWalletType'  => 'Wallet Type',
            'depositDescription' => 'Description',
        ]);

        try {
            DB::transaction(function () {
                // Get or create wallet
                $wallet = $this->getOrCreateWallet($this->depositWalletType);

                $balanceBefore = $wallet->balance;
                $balanceAfter  = $balanceBefore + $this->depositAmount;

                // Update wallet balance
                $wallet->update(['balance' => $balanceAfter]);

                // Create transaction record for NUBAN deposit
                $wallet->transactions()->create([
                    'transaction_type'            => 'credit',
                    'amount'                      => $this->depositAmount,
                    'balance_before'              => $balanceBefore,
                    'balance_after'               => $balanceAfter,
                    'transaction_description'     => 'NUBAN Deposit: ' . $this->depositDescription,
                    'transaction_reference'       => 'DEP-ADM-' . strtoupper(uniqid()),
                    'status'                      => 'completed',
                    'currency'                    => 'NGN',
                    'transaction_response_object' => json_encode([
                        'admin_action' => 'deposit',
                        'admin_id'     => Auth::id(),
                        'wallet_type'  => $this->depositWalletType,
                    ]),
                ]);
            });

            $this->closeDepositModal();
            $this->dispatch('refreshUserStats');
            session()->flash('success', 'Deposit processed successfully!');

        } catch (\Exception $e) {
            Log::error('Deposit failed: ' . $e->getMessage());
            session()->flash('error', 'Failed to process deposit. Please try again.');
        }
    }

    // Withdraw Methods
    public function openWithdrawModal()
    {
        $this->showWithdrawModal = true;
        $this->resetWithdrawForm();
    }

    public function closeWithdrawModal()
    {
        $this->showWithdrawModal = false;
        $this->resetWithdrawForm();
    }

    public function resetWithdrawForm()
    {
        $this->withdrawAmount      = '';
        $this->withdrawBankAccount = '';
        $this->withdrawDescription = '';
        $this->resetValidation();
    }

    public function processWithdraw()
    {
        $this->validate([
            'withdrawAmount'      => 'required|numeric|min:0.01|max:1000000',
            'withdrawWalletType'  => 'required|in:nuban',
            'withdrawBankAccount' => 'required|exists:bank_accounts,id',
            'withdrawDescription' => 'required|string|min:5|max:255',
        ], [], [
            'withdrawAmount'      => 'Amount',
            'withdrawWalletType'  => 'Wallet Type',
            'withdrawBankAccount' => 'Bank Account',
            'withdrawDescription' => 'Description',
        ]);

        try {
            DB::transaction(function () {
                // Get wallet
                $wallet = $this->getOrCreateWallet($this->withdrawWalletType);

                $balanceBefore = $wallet->balance;

                // Check sufficient balance
                if ($balanceBefore < $this->withdrawAmount) {
                    throw new \Exception('Insufficient balance for withdrawal.');
                }

                $balanceAfter = $balanceBefore - $this->withdrawAmount;

                // Update wallet balance
                $wallet->update(['balance' => $balanceAfter]);

                // Get bank account details
                $bankAccount = BankAccount::find($this->withdrawBankAccount);

                // Create transaction record for NUBAN withdrawal
                $wallet->transactions()->create([
                    'transaction_type'            => 'debit',
                    'amount'                      => $this->withdrawAmount,
                    'balance_before'              => $balanceBefore,
                    'balance_after'               => $balanceAfter,
                    'transaction_description'     => $this->withdrawDescription . ' (Withdrawal to: ' . $bankAccount->bank_name . ')',
                    'transaction_reference'       => 'WTH-ADM-' . strtoupper(uniqid()),
                    'status'                      => 'completed',
                    'currency'                    => 'NGN',
                    'transaction_response_object' => json_encode([
                        'admin_action' => 'withdraw',
                        'admin_id'     => Auth::id(),
                        'wallet_type'  => $this->withdrawWalletType,
                        'bank_account' => [
                            'bank_name'      => $bankAccount->bank_name,
                            'account_number' => $bankAccount->account_number,
                            'account_name'   => $bankAccount->account_name,
                        ],
                    ]),
                ]);
            });

            $this->closeWithdrawModal();
            $this->dispatch('refreshUserStats');
            session()->flash('success', 'Withdrawal of ' . number_format((float) $this->withdrawAmount, 2) . ' processed successfully!');

        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    // Transfer Methods
    public function openTransferModal()
    {
        $this->showTransferModal = true;
        $this->resetTransferForm();
    }

    public function closeTransferModal()
    {
        $this->showTransferModal = false;
        $this->resetTransferForm();
    }

    public function resetTransferForm()
    {
        $this->transferAmount      = '';
        $this->transferToUserId    = '';
        $this->transferDescription = '';
        $this->userSearchTerm      = '';
        $this->searchUsers         = [];
        $this->resetValidation();
    }

    public function processTransfer()
    {
        $this->validate([
            'transferAmount'         => 'required|numeric|min:0.01|max:1000000',
            'transferFromWalletType' => 'required|in:nuban',
            'transferToWalletType'   => 'required|in:nuban',
            'transferToUserId'       => 'required|exists:users,id',
            'transferDescription'    => 'required|string|min:5|max:255',
        ], [], [
            'transferAmount'         => 'Amount',
            'transferFromWalletType' => 'From Wallet',
            'transferToWalletType'   => 'To Wallet',
            'transferToUserId'       => 'Recipient',
            'transferDescription'    => 'Description',
        ]);

        try {
            DB::transaction(function () {
                // Get source wallet
                $fromWallet = $this->getOrCreateWallet($this->transferFromWalletType);

                $fromBalanceBefore = $fromWallet->balance;

                // Check sufficient balance
                if ($fromBalanceBefore < $this->transferAmount) {
                    throw new \Exception('Insufficient balance for transfer.');
                }

                // Get recipient user and wallet
                $toUser   = User::find($this->transferToUserId);
                $toWallet = $this->getOrCreateWalletForUser($toUser, $this->transferToWalletType);

                $fromBalanceAfter = $fromBalanceBefore - $this->transferAmount;
                $toBalanceBefore  = $toWallet->balance;
                $toBalanceAfter   = $toBalanceBefore + $this->transferAmount;

                // Update both wallets
                $fromWallet->update(['balance' => $fromBalanceAfter]);
                $toWallet->update(['balance' => $toBalanceAfter]);

                $reference = 'TRF-ADM-' . strtoupper(uniqid());

                // Create debit transaction for sender (NUBAN to NUBAN)
                $fromWallet->transactions()->create([
                    'transaction_type'            => 'debit',
                    'amount'                      => $this->transferAmount,
                    'balance_before'              => $fromBalanceBefore,
                    'balance_after'               => $fromBalanceAfter,
                    'transaction_description'     => 'NUBAN Transfer to ' . ($toUser->metaData->first_name ?? $toUser->email) . ' - ' . $this->transferDescription,
                    'transaction_reference'       => $reference,
                    'status'                      => 'completed',
                    'currency'                    => 'NGN',
                    'transaction_response_object' => json_encode([
                        'admin_action'    => 'transfer_debit',
                        'admin_id'        => Auth::id(),
                        'recipient_id'    => $toUser->id,
                        'recipient_email' => $toUser->email,
                        'wallet_type'     => $this->transferFromWalletType,
                    ]),
                ]);

                // Create credit transaction for recipient (NUBAN to NUBAN)
                $toWallet->transactions()->create([
                    'transaction_type'            => 'credit',
                    'amount'                      => $this->transferAmount,
                    'balance_before'              => $toBalanceBefore,
                    'balance_after'               => $toBalanceAfter,
                    'transaction_description'     => 'NUBAN Transfer from ' . ($this->user->metaData->first_name ?? $this->user->email) . ' - ' . $this->transferDescription,
                    'transaction_reference'       => $reference,
                    'status'                      => 'completed',
                    'currency'                    => 'NGN',
                    'transaction_response_object' => json_encode([
                        'admin_action' => 'transfer_credit',
                        'admin_id'     => Auth::id(),
                        'sender_id'    => $this->user->id,
                        'sender_email' => $this->user->email,
                        'wallet_type'  => $this->transferToWalletType,
                    ]),
                ]);
            });

            $this->closeTransferModal();
            $this->dispatch('refreshUserStats');
            session()->flash('success', 'Transfer processed successfully!');

        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    private function getOrCreateWallet($type)
    {
        return $this->getOrCreateWalletForUser($this->user, $type);
    }

    private function getOrCreateWalletForUser($user, $type)
    {
        $wallet = $user->wallets()->where('type', $type)->first();

        if (! $wallet) {
            // Since we're only supporting NUBAN now, create NUBAN wallet only
            $wallet = $user->wallets()->create([
                'type'           => 'nuban',
                'currency'       => 'NGN',
                'balance'        => 0.00,
                'status'         => 'active',
                'bank_name'      => 'TakersPay Bank',
                'account_number' => $this->generateAccountNumber(),
            ]);
        }

        return $wallet;
    }

    private function generateCryptoWalletNumber()
    {
        return 'BTC' . strtoupper(uniqid()) . rand(1000, 9999);
    }

    private function generateAccountNumber()
    {
        return '22' . str_pad(rand(1, 99999999), 8, '0', STR_PAD_LEFT);
    }

    public function render()
    {
        return view('livewire.admin.user-wallet-management-component');
    }
}
