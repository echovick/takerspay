<?php
namespace App\Traits;

use App\Constants\AssetType;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;

trait ChatSystem
{
    /**
     * Handles the input for the chat system.
     *
     * This function processes the input received from the user and performs
     * necessary actions based on the input.
     *
     * @return void
     */
    public function handleInput()
    {
        $this->setAdminWalletAndAccount();
        if (!$this->order && isset($this->ref)) {
            $this->order = Order::where('reference', $this->ref)->first();
        } else if (!$this->order && !isset($this->ref)) {
            return;
        }

        $userInput = trim($this->input);
        if (isset($userInput) && !empty($userInput)) {
            $this->addNewMessage($userInput);
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

        // Handle Image Upload
        if (isset($this->photos) && count($this->photos) > 0) {
            $userInput = isset($userInput) ? $userInput : "";
            $this->imageUpload($userInput);
            return;
        }

        // Chat flow logic
        $this->handleChatFlow($userInput);
        $this->input = '';
        $this->order->save();
    }

    /**
     * Handles the chat flow based on the user's input.
     *
     * @param string $userInput The input provided by the user.
     *
     * @return void
     */
    private function handleChatFlow(string $userInput)
    {
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

            case 'select_trade_currency':
                $this->handleSelectTradeCurrencyStep($userInput);
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
    }

    /**
     * Handles the first prompt for the user in the chat system.
     *
     * This function is responsible for managing the initial interaction
     * with the user when they first engage with the chat system.
     *
     * @return void
     */
    private function handleUserFirstPrompt()
    {
        $this->step = 'select_action';
        $this->order->order_step = 'select_action';
        $this->addMessage('Bot', 'Hello, Welcome to TakersPay, What would you like to do? (1: Buy Crypto, 2: Sell Crypto, 3: Buy Gift Card, 4: Sell Gift Card, 5: Reset Chat & Start Over)');
    }

    /**
     * Handles the selection action step based on user input.
     *
     * @param string $userInput The input provided by the user.
     *
     * @return void
     */
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
            $this->order->asset = AssetType::GIFT_CARD;
            $this->addMessage('Bot', "Which Card would you like to Buy? ({$this->giftCardAssets})");
            $this->order->order_step = 'select_gift_card';
            $this->step = 'select_gift_card';
            $this->order->type = 'buy';
        } elseif ($userInput == '4') {
            $this->order->type = 'sell';
            $this->order->asset = AssetType::GIFT_CARD;
            $this->addMessage('Bot', "Which Card would you like to Sell? ({$this->giftCardAssets})");
            $this->step = 'select_gift_card';
            $this->order->order_step = 'select_gift_card';
        } elseif ($userInput == '5') {
            $this->resetChat();
        } else {
            $this->addMessage('Bot', 'Invalid option. Please select 1, 2, 3, 4, or 5.');
        }
        $this->order->save();
    }

    /**
     * Handles the selection of a cryptocurrency step based on user input.
     *
     * @param string $userInput The input provided by the user for selecting a cryptocurrency.
     *
     * @return void
     */
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

    /**
     * Handles the selection of a gift card step based on user input.
     *
     * @param string $userInput The input provided by the user to select a gift card step.
     *
     * @return void
     */
    private function handleSelectGiftCardStep(string $userInput)
    {
        $this->data['currency'] = strtoupper($userInput);
        $asset = $this->assetService->getAsset($userInput, AssetType::GIFT_CARD);
        if (!$asset) {
            $this->addMessage('Bot', 'Invalid option. Please select from the options above');
            return;
        }
        $this->order->asset_id = $this->data['currency'];
        $this->order->asset = AssetType::GIFT_CARD;
        $this->addMessage('Bot', "Choose the currency of the Card (1: USD, 2: EUR, 3: GBP, 4: CAD, 5: AUD, 6: CNY, 7: JPY, 8: INR, 9: Reset Chat & Start Over)");
        $this->step = 'select_trade_currency';
        $this->order->order_step = 'select_trade_currency';
        $this->order->save();
    }

    /**
     * Handles the selection of trade currency step based on user input.
     *
     * @param string $userInput The input provided by the user to select the trade currency.
     *
     * @return void
     */
    private function handleSelectTradeCurrencyStep(string $userInput)
    {
        if ($userInput == '1') {
            $this->order->trade_currency = 'USD';
        } elseif ($userInput == '2') {
            $this->order->trade_currency = 'EUR';
        } elseif ($userInput == '3') {
            $this->order->trade_currency = 'GBP';
        } elseif ($userInput == '4') {
            $this->order->trade_currency = 'CAD';
        } elseif ($userInput == '5') {
            $this->order->trade_currency = 'AUD';
        } elseif ($userInput == '6') {
            $this->order->trade_currency = 'CNY';
        } elseif ($userInput == '7') {
            $this->order->trade_currency = 'JPY';
        } elseif ($userInput == '8') {
            $this->order->trade_currency = 'INR';
        } elseif ($userInput == '9') {
            $this->resetChat();
        } else {
            $this->addMessage('Bot', 'Invalid option. Please select from the options above');
            return;
        }
        $asset = $this->assetService->getAsset($this->order->asset_id);
        $this->step = 'enter_amount';
        $this->order->order_step = 'enter_amount';
        $this->addMessage('Bot', "How much worth of {$asset?->name} in ({$this->order->trade_currency}) would you like to {$this->order->type}?");
        $this->order->save();
    }

    /**
     * Handles the step where the user enters an amount.
     *
     * @param string $userInput The input provided by the user.
     *
     * @return void
     */
    private function handleEnterAmountStep(string $userInput)
    {
        $this->sendNewOrderNotificationToAdmin();
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
            $this->addMessage('Bot', "Noted!. You will be required to send {$amount} {$this->order?->trade_currency} worth of naira to the account details we will provide after you have confirmed the order. Do you want to proceed? (yes/cancel)");
        } else if ($this->order->type == 'sell' && $this->order->asset == 'giftcard') {
            $this->addMessage('Bot', "Noted!. You will be required to send a picture of both sides of your gift card (You can select multiple images at once). Do you want to proceed? (yes/cancel)");
        }

        $this->order->asset_value = $amount;
        $this->order->naira_price = $nairaEquivalent;
        $this->order->save();
    }

    /**
     * Handles the upload step for gift cards in the chat system.
     *
     * This function manages the process of uploading gift cards, ensuring that
     * the necessary steps are followed and any required validations are performed.
     *
     * @return void
     */
    private function handleGiftCardUploadStep()
    {
        $fileUrl = '';
        $this->validate(['photos.*' => 'image|max:1024']);

        foreach ($this->photos as $photo) {
            $result = $photo->storeOnCloudinaryAs('images', $photo->getClientOriginalName());
            $path = $result->getSecurePath();
            $url = Storage::url($path);
            $fileUrl .= $url . ',';
        }

        $fileUrl = rtrim($fileUrl, ',');
        $this->order->file_url = $fileUrl;
        $this->addMessage('Bot', "Received!, your account will be credited with in a few mins, thanks for trusting TakersPay");
        $this->order->save();
    }

    /**
     * Handles the confirmation step of a purchase process based on user input.
     *
     * @param string $userInput The input provided by the user to confirm the purchase.
     *
     * @return void
     */
    private function handleConfirmPurchaseStep(string $userInput)
    {
        if (strtolower($userInput) === 'yes') {
            $asset = $this->assetService->getAsset($this->order->asset_id);
            $this->order->save();
            if ($this->order->type == 'buy' && $this->order->asset == 'crypto') {
                $this->addMessage('Bot', "Your purchase order has been taken and confirmed!, Please send ₦{$this->order->naira_price} to ({$this->adminAccount?->account_number} @ {$this->adminAccount?->bank_name} - {$this->adminAccount?->account_number}) with the order reference as narration, you will receive {$this->order->asset_value} dollar worth of {$asset->name} in your saved wallet once your payment is confirmed by us. Please feel free to reach out to us if you encounter any issues or complaints");
            } else if ($this->order->type == 'sell' && $this->order->asset == 'crypto') {
                $this->addMessage('Bot', "Your sell order has been taken and confirmed!, Please send {$this->order->asset_value} dollar worth of {$asset->name} to ({$this?->adminWallet?->crypto_wallet_number}). Please feel free to reach out to us if you encounter any issues or complaints");
            } else if ($this->order->type == 'buy' && $this->order->asset == 'giftcard') {
                $this->addMessage('Bot', "Your purchase order has been taken and confirmed!, Please send ₦{$this->order->asset_value} to ({$this->adminAccount?->account_number} @ {$this->adminAccount?->bank_name} - {$this->adminAccount?->account_number}) with the order reference as narration, Once your payment is confirmed, you will receive your giftcard. Please feel free to reach out to us if you encounter any issues or complaints");
            } else if ($this->order->type == 'sell' && $this->order->asset == 'giftcard') {
                $this->addMessage('Bot', "Your sell order has been taken and confirmed!, Please send the back and front picture of your giftcard, once confirmed by us, your naira account will be credited. Please feel free to reach out to us if you encounter any issues or complaints");
                $this->step = 'upload_gift_card';
                $this->order->order_step = 'upload_gift_card';
            }
            $this->order->save();

            $this->addMessage('Bot', "Please send your payment confirmation to us for verification, Note that this Order will be cancelled if there is no payment confirmation after 24hours, thanks for choosing TakersPay");
        } else {
            $this->order->order_step = 'canceled';
            $this->addMessage('Bot', 'Purchase canceled.');
            $this->resetChat();
        }
    }
}
