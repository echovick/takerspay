<?php

namespace App\Livewire\Orders;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OrderRecord extends Component
{
    public $order;
    public $messages = [];
    public $input = '';
    public $step = null;
    public $data = [];

    public function boot()
    {
        $this->setOrder();
    }

    public function render()
    {
        return view('livewire.orders.order-record');
    }

    public function handleInput()
    {
        $userInput = trim($this->input);
        if (isset($userInput) && !empty($userInput)) {
            $this->addMessage('user', $userInput);
        }

        // Handle "cancel" command
        if (strtolower($userInput) === 'cancel') {
            $this->resetChat();
            return;
        }

        // Chat flow logic
        switch ($this->step) {
            case null:
                $this->step = 'select_action';
                $this->order->order_step = 'select_action';
                $this->addMessage('Bot', 'Hello, Welcome to TakersPay, What would you like to do? (1: Buy Crypto, 2: Sell Crypto, 3: Buy Gift Card, 4: Sell Gift Card)');
                break;

            case 'select_action':
                $this->data['action'] = $userInput;
                if ($userInput == '1') {
                    $this->step = 'select_currency';
                    $this->order->order_step = 'select_currency';
                    $this->addMessage('Bot', 'Which currency would you like to buy? (BTC, ETH, USDT)');
                } elseif ($userInput == '2') {
                    $this->addMessage('Bot', 'Selling Crypto is under development.');
                    $this->resetChat();
                } elseif ($userInput == '3') {
                    $this->addMessage('Bot', 'Buying Gift Cards is under development.');
                    $this->resetChat();
                } elseif ($userInput == '4') {
                    $this->addMessage('Bot', 'Selling Gift Cards is under development.');
                    $this->resetChat();
                } else {
                    $this->addMessage('Bot', 'Invalid option. Please select 1, 2, 3, or 4.');
                }
                break;

            case 'select_currency':
                $this->data['currency'] = strtoupper($userInput);
                $this->step = 'enter_amount';
                $this->order->order_step = 'enter_amount';
                $this->addMessage('Bot', 'How much in dollars would you like to buy?');
                break;

            case 'enter_amount':
                $amount = (float) $userInput;
                if ($amount <= 0) {
                    $this->addMessage('Bot', 'Please enter a valid amount.');
                    break;
                }
                $this->data['amount'] = $amount;

                // Example conversion logic
                $rate = 750; // Naira per dollar
                $tokens = $amount; // Assume 1 token = $1
                $nairaEquivalent = $amount * $rate;

                $this->addMessage('Bot', "You will get {$tokens} tokens for ₦{$nairaEquivalent}. Confirm? (yes/cancel)");
                $this->step = 'confirm_purchase';
                $this->order->order_step = 'confirm_purchase';
                break;

            case 'confirm_purchase':
                if (strtolower($userInput) === 'yes') {
                    $this->order->order_step = 'confirmed';
                    $this->order->confirmed_at = Carbon::now();
                    $this->addMessage('Bot', 'Your purchase has been confirmed!');
                    $this->resetChat();
                } else {
                    $this->order->order_step = 'canceled';
                    $this->addMessage('Bot', 'Purchase canceled.');
                    $this->resetChat();
                }
                break;

            default:
                $this->resetChat();
        }

        $this->input = '';
        $this->order->save();
    }

    private function addMessage($sender, $text)
    {
        $this->messages[] = ['sender' => $sender, 'text' => $text];
        $this->updateChatRecordOnDb($this->messages);
    }

    private function updateChatRecordOnDb(array $chat)
    {
        $this->order->chat = $chat;
        $this->order->save();
    }

    private function resetChat()
    {
        $this->messages[] = ['sender' => 'Bot', 'text' => 'Chat has been reset.'];
        $this->step = null;
        $this->data = [];
    }

    private function setOrder()
    {
        if (session()->has('orderId')) {
            $this->order = Order::find(session('orderId'));
            if (!$this->order) {
                $this->newOrder();
                return;
            }
            if ($this->order->chat) {
                $this->messages = json_decode($this->order->chat, true);
            }
            if ($this->order->order_step) {
                $this->step = $this->order->order_step;
            }
        } else if (isset($_GET['ref'])) {
            $this->order = Order::where('reference', $_GET['ref'])->first();
            if (!$this->order) {
                $this->newOrder();
                return;
            }
            if ($this->order->chat) {
                $this->messages = json_decode($this->order->chat, true);
            }
            if ($this->order->order_step) {
                $this->step = $this->order->order_step;
            }
        } else {

        }
    }

    private function newOrder()
    {
        $user = Auth::user();
        $this->order = Order::create([
            'user_id' => $user->id,
            'reference' => 'TP' . date('ymdhis'),
        ]);
        session(['orderId' => $this->order->id]);
    }
}
