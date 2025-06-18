<?php
namespace App\Livewire\Admin;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use App\Services\WalletService;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class UserWalletOperations extends Component
{
    public $user;
    public $userId;
    public $wallet;

    // Deposit properties
    public $depositAmount;
    public $depositMethod;
    public $depositDescription;

    // Transfer properties
    public $recipientEmail;
    public $transferAmount;
    public $transferDescription;

    // Alert messages
    public $successMessage = '';
    public $errorMessage   = '';

    protected WalletService $walletService;

    public function boot(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    public function mount($userId)
    {
        $this->userId = $userId;
        $this->loadUser();
    }

    public function loadUser()
    {
        $this->user   = User::find($this->userId);
        $this->wallet = $this->user ? $this->user->wallet : null;
    }

    public function deposit()
    {
        $this->resetMessages();

        try {
            // Validate input
            $this->validate([
                'depositAmount'      => 'required|numeric|min:0.01',
                'depositMethod'      => 'required|string',
                'depositDescription' => 'nullable|string|max:255',
            ]);

            // Check if wallet exists
            if (! $this->wallet) {
                throw new Exception('User does not have a wallet.');
            }

            DB::beginTransaction();

            // Get current balance
            $currentBalance = $this->wallet->balance;
            $newBalance     = $currentBalance + $this->depositAmount;

            // Create transaction record
            $transaction = Transaction::create([
                'wallet_id'               => $this->wallet->id,
                'amount'                  => $this->depositAmount,
                'currency'                => $this->wallet->currency ?? 'USD',
                'status'                  => 'completed',
                'balance_before'          => $currentBalance,
                'balance_after'           => $newBalance,
                'transaction_reference'   => 'ADMIN-DEP-' . time(),
                'transaction_type'        => 'deposit',
                'transaction_description' => $this->depositDescription ?? 'Admin deposit',
                'transaction_date'        => now(),
            ]);

            // Update wallet balance
            $this->walletService->updateWallet($this->wallet->id, [
                'balance' => $newBalance,
            ]);

            DB::commit();

            // Reset form fields
            $this->resetDeposit();
            $this->loadUser(); // Reload user and wallet data
            $this->successMessage = "Successfully deposited {$this->depositAmount} {$this->wallet->currency} to user's wallet.";
            $this->dispatch('wallet-operation-completed', ['type' => 'deposit']);

        } catch (Exception $e) {
            DB::rollBack();
            $this->errorMessage = $e->getMessage();
        }
    }

    public function transfer()
    {
        $this->resetMessages();

        try {
            // Validate input
            $this->validate([
                'recipientEmail'      => 'required|email|exists:users,email',
                'transferAmount'      => 'required|numeric|min:0.01',
                'transferDescription' => 'nullable|string|max:255',
            ]);

            // Check if sender wallet exists
            if (! $this->wallet) {
                throw new Exception('User does not have a wallet.');
            }

            // Check if sender has sufficient balance
            if ($this->wallet->balance < $this->transferAmount) {
                throw new Exception('Insufficient balance in user wallet.');
            }

            // Find recipient
            $recipient = User::where('email', $this->recipientEmail)->first();
            if (! $recipient) {
                throw new Exception('Recipient not found.');
            }

            // Find recipient wallet
            $recipientWallet = $recipient->wallet;
            if (! $recipientWallet) {
                throw new Exception('Recipient does not have a wallet.');
            }

            DB::beginTransaction();

            // Get current balances
            $senderBalanceBefore    = $this->wallet->balance;
            $recipientBalanceBefore = $recipientWallet->balance;

            // Calculate new balances
            $senderBalanceAfter    = $senderBalanceBefore - $this->transferAmount;
            $recipientBalanceAfter = $recipientBalanceBefore + $this->transferAmount;

            // Create sender transaction record (debit)
            Transaction::create([
                'wallet_id'               => $this->wallet->id,
                'amount'                  => $this->transferAmount,
                'currency'                => $this->wallet->currency ?? 'USD',
                'status'                  => 'completed',
                'balance_before'          => $senderBalanceBefore,
                'balance_after'           => $senderBalanceAfter,
                'transaction_reference'   => 'ADMIN-TRANSFER-OUT-' . time(),
                'transaction_type'        => 'transfer_out',
                'transaction_description' => $this->transferDescription ?? "Admin transfer to {$recipient->email}",
                'transaction_date'        => now(),
            ]);

            // Create recipient transaction record (credit)
            Transaction::create([
                'wallet_id'               => $recipientWallet->id,
                'amount'                  => $this->transferAmount,
                'currency'                => $recipientWallet->currency ?? 'USD',
                'status'                  => 'completed',
                'balance_before'          => $recipientBalanceBefore,
                'balance_after'           => $recipientBalanceAfter,
                'transaction_reference'   => 'ADMIN-TRANSFER-IN-' . time(),
                'transaction_type'        => 'transfer_in',
                'transaction_description' => $this->transferDescription ?? "Admin transfer from {$this->user->email}",
                'transaction_date'        => now(),
            ]);

            // Update wallet balances
            $this->walletService->updateWallet($this->wallet->id, [
                'balance' => $senderBalanceAfter,
            ]);

            $this->walletService->updateWallet($recipientWallet->id, [
                'balance' => $recipientBalanceAfter,
            ]);

            DB::commit();

            // Reset form fields
            $this->resetTransfer();
            $this->loadUser(); // Reload user and wallet data
            $this->successMessage = "Successfully transferred {$this->transferAmount} {$this->wallet->currency} to {$recipient->email}.";
            $this->dispatch('wallet-operation-completed', ['type' => 'transfer']);

        } catch (Exception $e) {
            DB::rollBack();
            $this->errorMessage = $e->getMessage();
        }
    }

    private function resetDeposit()
    {
        $this->depositAmount      = null;
        $this->depositMethod      = null;
        $this->depositDescription = null;
    }

    private function resetTransfer()
    {
        $this->recipientEmail      = null;
        $this->transferAmount      = null;
        $this->transferDescription = null;
    }

    private function resetMessages()
    {
        $this->successMessage = '';
        $this->errorMessage   = '';
    }

    public function render()
    {
        return view('livewire.admin.user-wallet-operations');
    }
}
