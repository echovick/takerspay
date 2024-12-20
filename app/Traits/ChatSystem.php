<?php
namespace App\Traits;

use App\Constants\AssetType;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

trait ChatSystem
{
    public function handleInput()
    {
        $userInput = trim($this->input);
        if (isset($userInput) && !empty($userInput)) {
            $sender = Auth::user()->role == 'user' ? 'user' : 'Bot';
            $this->addMessage($sender, $userInput);
        }

        // Handle "reset" command
        if (strtolower($userInput) === 'reset') {
            $this->resetChat();
            return;
        }

        // Handle "cancel" command
        if (strtolower($userInput) === 'cancel') {
            $this->cancelChat();
            return;
        }

        // Chat flow logic
        switch ($this->step) {
            case null:
                $this->handleUserFirstPrompt();
                break;

            case 'select_action':
                $this->handleSelectActionStep($userInput);
                break;

            case 'select_gift_card':
                $this->handleSelectGiftCardStep($userInput);
                break;

            case 'select_currency':
                $this->handleSelectCryptoStep($userInput);
                break;

            case 'enter_amount':
                $this->handleEnterAmountStep($userInput);
                break;

            case 'confirm_purchase':
                $this->handleConfirmPurchaseStep($userInput);
                break;
            case 'upload_gift_card':
                $this->handleGiftCardUploadStep($userInput);
                break;

            default:
                $this->resetChat();
        }

        $this->input = '';
        $this->order->save();
    }

    private function handleUserFirstPrompt()
    {
        $this->step = 'select_action';
        $this->order->order_step = 'select_action';
        $this->addMessage('Bot', 'Hello, Welcome to TakersPay, What would you like to do? (1: Buy Crypto, 2: Sell Crypto, 3: Buy Gift Card, 4: Sell Gift Card, 5: Reset Chat & Start Over)');
    }

    private function handleSelectActionStep(string $userInput)
    {
        $this->data['action'] = $userInput;
        if ($userInput == '1') {
            $this->step = 'select_currency';
            $this->order->type = 'buy';
            $this->order->asset = AssetType::CRYPTO;
            $this->order->order_step = 'select_currency';
            $this->addMessage('Bot', "Which currency would you like to buy? ({$this->cryptoAssets})");
        } elseif ($userInput == '2') {
            $this->step = 'select_currency';
            $this->order->type = 'sell';
            $this->order->asset = AssetType::CRYPTO;
            $this->order->order_step = 'select_currency';
            $this->addMessage('Bot', "Which currency would you like to sell? ({$this->cryptoAssets})");
        } elseif ($userInput == '3') {
            $this->step = 'select_gift_card';
            $this->order->type = 'buy';
            $this->order->asset = AssetType::GIFT_CARD;
            $this->order->order_step = 'select_gift_card';
            $this->addMessage('Bot', "Which Card would you like to Buy? ({$this->giftCardAssets})");
        } elseif ($userInput == '4') {
            $this->step = 'select_gift_card';
            $this->order->type = 'sell';
            $this->order->asset = AssetType::GIFT_CARD;
            $this->order->order_step = 'select_gift_card';
            $this->addMessage('Bot', "Which Card would you like to Sell? ({$this->giftCardAssets})");
        } elseif ($userInput == '5') {
            $this->resetChat();
        } else {
            $this->addMessage('Bot', 'Invalid option. Please select 1, 2, 3, 4, or 5.');
        }
        $this->order->save();
    }

    private function handleSelectCryptoStep(string $userInput)
    {
        $this->data['currency'] = strtoupper($userInput);
        $asset = $this->assetService->getAsset($userInput, AssetType::CRYPTO);
        if (!$asset) {
            $this->addMessage('Bot', 'Invalid option. Please select from the options above');
            return;
        }
        $this->step = 'enter_amount';
        $this->order->order_step = 'enter_amount';
        $this->order->asset_id = $this->data['currency'];
        $this->order->asset = AssetType::CRYPTO;
        $this->addMessage('Bot', "How much in dollars would you like to {$this->order->type}?");
        $this->order->save();
    }

    private function handleSelectGiftCardStep(string $userInput)
    {
        $this->data['currency'] = strtoupper($userInput);
        $asset = $this->assetService->getAsset($userInput, AssetType::GIFT_CARD);
        if (!$asset) {
            $this->addMessage('Bot', 'Invalid option. Please select from the options above');
            return;
        }
        $this->step = 'enter_amount';
        $this->order->order_step = 'enter_amount';
        $this->order->asset_id = $this->data['currency'];
        $this->order->asset = AssetType::GIFT_CARD;
        $this->addMessage('Bot', "How much worth of {$asset->name} (In Naira) would you like to {$this->order->type}?");
        $this->order->save();
    }

    private function handleEnterAmountStep(string $userInput)
    {
        $amount = (float) $userInput;
        if ($amount <= 0) {
            $this->addMessage('Bot', 'Please enter a valid amount.');
            return;
        }
        $this->data['amount'] = $amount;

        $asset = $this->assetService->getAsset($this->order->asset_id);
        $rate = $this->order->type == 'buy' ? $asset->naira_sell_rate : $asset->naira_buy_rate;
        $nairaEquivalent = $this->order->asset == 'crypto' ? $amount * $rate : $amount;

        $this->step = 'confirm_purchase';
        $this->order->order_step = 'confirm_purchase';
        if ($this->order->type == 'buy' && $this->order->asset == 'crypto') {
            $this->addMessage('Bot', "Noted!. at our rate of {$rate}/$ You will send ₦{$nairaEquivalent} to the account details we will provide after you have confirmed the order. Do you want to proceed? (yes/cancel)");
        } else if ($this->order->type == 'sell' && $this->order->asset == 'crypto') {
            $this->addMessage('Bot', "Noted!. at our rate of {$rate}/$ You will receive ₦{$nairaEquivalent} to your naira account after sending {$amount} dollars worth of crypto to the wallet address we will provide after you have confirmed the order. Do you want to proceed? (yes/cancel)");
        } else if ($this->order->type == 'buy' && $this->order->asset == 'giftcard') {
            $this->addMessage('Bot', "Noted!. You will be required to send {$amount} naira to the account details we will provide after you have confirmed the order. Do you want to proceed? (yes/cancel)");
        } else if ($this->order->type == 'sell' && $this->order->asset == 'giftcard') {
            $this->addMessage('Bot', "Noted!. You will be required to send a picture of both sides of your gift card (You can select multiple images at once). Do you want to proceed? (yes/cancel)");
        }

        $this->order->asset_value = $amount;
        $this->order->naira_price = $nairaEquivalent;
        $this->order->save();
    }

    private function handleGiftCardUploadStep(string $userInput)
    {
        $fileUrl = '';
        $this->validate(['photos.*' => 'image|max:1024']);

        foreach ($this->photos as $photo) {
            $path = $photo->storePublicly('photos', 'public');
            $url = Storage::url($path);
            $fileUrl .= $url . ',';
        }

        $fileUrl = rtrim($fileUrl, ',');
        $this->order->file_url = $fileUrl;
        $this->order->order_step = 'confirmed';
        $this->order->confirmed_at = Carbon::now();
        $this->order->transaction_status = 'confirmed';
        $this->addMessage('Bot', "Received!, your account will be credited with in a few mins, thanks for trusting TakersPay");
        $this->order->save();
    }

    private function handleConfirmPurchaseStep(string $userInput)
    {
        if (strtolower($userInput) === 'yes') {
            $this->order->order_step = 'confirmed';
            $this->order->confirmed_at = Carbon::now();
            $this->order->transaction_status = 'confirmed';
            $asset = $this->assetService->getAsset($this->order->asset_id);
            $this->order->save();
            if ($this->order->type == 'buy' && $this->order->asset == 'crypto') {
                $this->addMessage('Bot', "Your purchase order has been taken and confirmed!, Please send ₦{$this->order->naira_price} to (0225644127 @ GTBANK - UCHECHUKWU EZE) with the order reference as narration, you will receive {$this->order->asset_value} dollar worth of {$asset->name} in your saved wallet once your payment is confirmed by us. Please feel free to reach out to us if you encounter any issues or complaints");
            } else if ($this->order->type == 'sell' && $this->order->asset == 'crypto') {
                $this->addMessage('Bot', "Your sell order has been taken and confirmed!, Please send {$this->order->asset_value} dollar worth of {$asset->name} to (0x6B19B8cB4D63B1cFf89F1A3627f6cE1fD6A7C48D), you will receive {$this->order->asset_value} dollar worth of {$asset->name} to the wallet address {$asset->wallet_address}. Please feel free to reach out to us if you encounter any issues or complaints");
            } else if ($this->order->type == 'buy' && $this->order->asset == 'giftcard') {
                $this->addMessage('Bot', "Your purchase order has been taken and confirmed!, Please send ₦{$this->order->asset_value} to (0225644127 @ GTBANK - UCHECHUKWU EZE) with the order reference as narration, Once your payment is confirmed, you will receive your giftcard. Please feel free to reach out to us if you encounter any issues or complaints");
            } else if ($this->order->type == 'sell' && $this->order->asset == 'giftcard') {
                $this->addMessage('Bot', "Your sell order has been taken and confirmed!, Please send the back and front picture of your giftcard, once confirmed by us, your naira account will be credited. Please feel free to reach out to us if you encounter any issues or complaints");
                $this->step = 'upload_gift_card';
                $this->order->order_step = 'upload_gift_card';
            }
            $this->order->save();

            $this->addMessage('Bot', "Note that this Order will be cancelled if there is no payment confirmation after 24hours, thanks for choosing TakersPay");
        } else {
            $this->order->order_step = 'canceled';
            $this->addMessage('Bot', 'Purchase canceled.');
            $this->resetChat();
        }
    }

    private function resetChat()
    {
        $this->messages[] = ['sender' => 'Bot', 'text' => 'Chat has been reset.', 'timestamp' => Carbon::now()];
        $this->step = null;
        $this->data = [];
    }

    private function cancelChat()
    {
        $this->order->transaction_status = 'canceled';
        $this->order->save();
        $this->step = null;
        $this->data = [];
    }

    private function addMessage($sender, $text)
    {
        $this->messages[] = ['sender' => $sender, 'text' => $text, 'timestamp' => Carbon::now()];
        $this->updateChatRecordOnDb($this->messages);
    }
}
