<?php
namespace App\Traits;

use App\Constants\AssetType;
use App\Models\Asset;
use App\Models\Order;
use App\Services\CurrencyService;
use Exception;
use Illuminate\Support\Facades\Storage;

trait ChatSystem
{
    protected CurrencyService $currencyService;

    /**
     * Initialize the currency service
     */
    private function initializeCurrencyService(): void
    {
        if (!isset($this->currencyService)) {
            $this->currencyService = app(CurrencyService::class);
        }
    }

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
        $this->initializeCurrencyService();
        $this->setAdminWalletAndAccount();
        if (! $this->order && isset($this->ref)) {
            $this->order = Order::where('reference', $this->ref)->first();
        } else if (! $this->order && ! isset($this->ref)) {
            return;
        }

        $userInput = trim($this->input);
        if (isset($userInput) && ! empty($userInput)) {
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

        // Handle "back" command
        if (strtolower($userInput) === 'back') {
            if ($this->handleBackNavigation()) {
                $this->order->save();
                return;
            }
        }

        // Handle rate inquiry
        if (strpos($userInput, "today") !== false && strpos($userInput, "rate") !== false) {
            $this->returnTodayRate();
            return;
        }

        // Handle start command
        if (strtolower($userInput) === 'start') {
            $this->resetChat();
            $this->handleUserFirstPrompt();
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
        
        $this->addMessage('Bot', "🌟 Welcome to TakersPay!");
        $this->addMessage('Bot', "Your trusted platform for crypto and gift card transactions.");
        $this->addMessage('Bot', "");
        $this->addMessage('Bot', "What would you like to do today?");
        $this->addMessage('Bot', "1️⃣ Buy Cryptocurrency");
        $this->addMessage('Bot', "2️⃣ Sell Cryptocurrency"); 
        $this->addMessage('Bot', "3️⃣ Buy Gift Cards");
        $this->addMessage('Bot', "4️⃣ Sell Gift Cards");
        $this->addMessage('Bot', "📊 Check Today's Rates");
        $this->addMessage('Bot', "");
        $this->addMessage('Bot', "💡 Tips: You can type numbers (1-4) or commands like 'rates', 'help', or 'reset'");
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
        $input = strtolower(trim($userInput));
        $this->data['action'] = $input;
        
        if ($input == '1' || str_contains($input, 'buy') && str_contains($input, 'crypto')) {
            $this->step = 'select_currency';
            $this->order->type = 'buy';
            $this->order->asset = AssetType::CRYPTO;
            $this->order->order_step = 'select_currency';
            
            $this->addMessage('Bot', "💰 BUY CRYPTOCURRENCY");
            $this->addMessage('Bot', "Select the cryptocurrency you'd like to buy:");
            $this->displayAssetOptions(AssetType::CRYPTO);
            
        } elseif ($input == '2' || str_contains($input, 'sell') && str_contains($input, 'crypto')) {
            $this->step = 'select_currency';
            $this->order->type = 'sell';
            $this->order->asset = AssetType::CRYPTO;
            $this->order->order_step = 'select_currency';
            
            $this->addMessage('Bot', "💸 SELL CRYPTOCURRENCY");
            $this->addMessage('Bot', "Select the cryptocurrency you'd like to sell:");
            $this->displayAssetOptions(AssetType::CRYPTO);
            
        } elseif ($input == '3' || str_contains($input, 'buy') && str_contains($input, 'gift')) {
            $this->order->asset = AssetType::GIFT_CARD;
            $this->order->type = 'buy';
            $this->step = 'select_gift_card';
            $this->order->order_step = 'select_gift_card';
            
            $this->addMessage('Bot', "🎁 BUY GIFT CARDS");
            $this->addMessage('Bot', "Select the gift card you'd like to buy:");
            $this->displayAssetOptions(AssetType::GIFT_CARD);
            
        } elseif ($input == '4' || str_contains($input, 'sell') && str_contains($input, 'gift')) {
            $this->order->type = 'sell';
            $this->order->asset = AssetType::GIFT_CARD;
            $this->step = 'select_gift_card';
            $this->order->order_step = 'select_gift_card';
            
            $this->addMessage('Bot', "💳 SELL GIFT CARDS");
            $this->addMessage('Bot', "Select the gift card you'd like to sell:");
            $this->displayAssetOptions(AssetType::GIFT_CARD);
            
        } elseif (str_contains($input, 'rate') || str_contains($input, 'price')) {
            $this->returnTodayRate();
            return; // Don't save order yet
            
        } elseif (str_contains($input, 'help')) {
            $this->showHelp();
            return; // Don't save order yet
            
        } elseif (str_contains($input, 'reset') || $input == '5') {
            $this->resetChat();
            $this->handleUserFirstPrompt();
            return;
            
        } else {
            $this->addMessage('Bot', '❌ Invalid option. Please select:');
            $this->addMessage('Bot', '• Numbers 1-4 for transactions');
            $this->addMessage('Bot', '• Type "rates" to check current rates');
            $this->addMessage('Bot', '• Type "help" for assistance');
            $this->addMessage('Bot', '• Type "reset" to start over');
            return;
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
        // Handle both numeric (1,2,3) and text inputs (BTC, ETH, BITCOIN)
        $asset = $this->findAssetByInput($userInput, AssetType::CRYPTO);
        
        if (!$asset) {
            $this->addMessage('Bot', 'Invalid option. Please select from the options above or type the asset name (e.g., "BTC" or "Bitcoin").');
            return;
        }
        
        $this->data['currency'] = $asset->slug;
        $this->step = 'enter_amount';
        $this->order->order_step = 'enter_amount';
        $this->order->asset_id = $asset->id;
        $this->order->asset = AssetType::CRYPTO;
        
        $this->addMessage('Bot', "Great choice! How much in US dollars would you like to {$this->order->type}? (Minimum: \$10)");
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
        // Handle both numeric (1,2,3) and text inputs (AMAZON, ITUNES, etc.)
        $asset = $this->findAssetByInput($userInput, AssetType::GIFT_CARD);
        
        if (!$asset) {
            $this->addMessage('Bot', 'Invalid option. Please select from the options above or type the card name (e.g., "Amazon" or "iTunes").');
            return;
        }
        
        $this->data['currency'] = $asset->slug;
        $this->order->asset_id = $asset->id;
        $this->order->asset = AssetType::GIFT_CARD;
        
        $this->addMessage('Bot', "Great choice! Choose the currency of the {$asset->name} card:");
        $this->addMessage('Bot', "1: USD 🇺🇸  2: EUR 🇪🇺  3: GBP 🇬🇧  4: CAD 🇨🇦");
        $this->addMessage('Bot', "5: AUD 🇦🇺  6: CNY 🇨🇳  7: JPY 🇯🇵  8: INR 🇮🇳");
        $this->addMessage('Bot', "Or type 'back' to go back, 'reset' to start over");
        
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
        $input = trim($userInput);
        
        // Map numeric inputs to currencies
        $currencyMap = [
            '1' => 'USD', '2' => 'EUR', '3' => 'GBP', '4' => 'CAD',
            '5' => 'AUD', '6' => 'CNY', '7' => 'JPY', '8' => 'INR'
        ];
        
        // Also support direct currency code input
        $supportedCurrencies = ['USD', 'EUR', 'GBP', 'CAD', 'AUD', 'CNY', 'JPY', 'INR'];
        $upperInput = strtoupper($input);
        
        if (isset($currencyMap[$input])) {
            $this->order->trade_currency = $currencyMap[$input];
        } elseif (in_array($upperInput, $supportedCurrencies)) {
            $this->order->trade_currency = $upperInput;
        } elseif (strtolower($input) === 'back') {
            return; // Back navigation handled in main handleInput
        } elseif (strtolower($input) === 'reset') {
            $this->resetChat();
            $this->handleUserFirstPrompt();
            return;
        } else {
            $this->addMessage('Bot', '❌ Invalid currency selection.');
            $this->addMessage('Bot', 'Please select 1-8 or type currency code (e.g., "USD", "EUR")');
            $this->addMessage('Bot', 'Type "back" to go back or "reset" to start over');
            return;
        }
        
        $asset = $this->assetService->getAsset($this->order->asset_id);
        $currency = $this->order->trade_currency;
        
        // Validate if currency is supported by our service
        if (!$this->currencyService->isCurrencySupported($currency)) {
            $this->addMessage('Bot', "Sorry, {$currency} is not currently supported.");
            $this->addMessage('Bot', 'Please select from the available options above.');
            return;
        }
        
        $this->step = 'enter_amount';
        $this->order->order_step = 'enter_amount';
        
        $currencySymbol = $this->currencyService->formatCurrency(0, $currency);
        $currencySymbol = str_replace('0.00', '', $currencySymbol); // Get just the symbol
        
        $this->addMessage('Bot', "💱 Currency selected: {$currency}");
        $this->addMessage('Bot', "");
        $this->addMessage('Bot', "How much worth of {$asset->name} in {$currency} would you like to {$this->order->type}?");
        $this->addMessage('Bot', "💡 Minimum amount: {$currencySymbol}25");
        $this->addMessage('Bot', "💡 Enter amount without currency symbol (e.g., just type '100')");
        
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
        
        // Validate amount input
        $amount = (float) $userInput;
        if ($amount <= 0) {
            $this->addMessage('Bot', 'Please enter a valid amount greater than 0. Try again.');
            return;
        }

        // Validate minimum transaction amounts
        if ($this->order->asset == 'crypto' && $amount < 10) {
            $this->addMessage('Bot', 'Minimum crypto transaction is $10. Please enter a higher amount.');
            return;
        }

        if ($this->order->asset == 'giftcard' && $amount < 25) {
            $currency = $this->order->trade_currency ?? 'USD';
            $this->addMessage('Bot', "Minimum gift card transaction is {$currency} 25. Please enter a higher amount.");
            return;
        }

        $this->data['amount'] = $amount;
        $asset = $this->assetService->getAsset($this->order->asset_id);
        
        if (!$asset) {
            $this->addMessage('Bot', 'Sorry, this asset is not available. Please restart the chat.');
            $this->resetChat();
            return;
        }

        try {
            // Calculate naira equivalent based on asset type
            if ($this->order->asset == 'crypto') {
                $nairaEquivalent = $this->currencyService->calculateCryptoNairaEquivalent($amount, $asset, $this->order->type);
                $dollarAmount = $amount;
            } else {
                $currency = $this->order->trade_currency ?? 'USD';
                $nairaEquivalent = $this->currencyService->calculateGiftCardNairaEquivalent($amount, $currency, $asset, $this->order->type);
                $dollarAmount = $this->currencyService->convertCurrency($amount, $currency, 'USD');
            }

            // Get the rate used for transparency
            $rate = $this->order->type == 'buy' ? $asset->naira_sell_rate : $asset->naira_buy_rate;
            
            $this->step = 'confirm_purchase';
            $this->order->order_step = 'confirm_purchase';
            
            // Generate confirmation messages with better formatting
            if ($this->order->type == 'buy' && $this->order->asset == 'crypto') {
                $this->addMessage('Bot', "📋 ORDER SUMMARY");
                $this->addMessage('Bot', "Asset: {$asset->name}");
                $this->addMessage('Bot', "Amount: \${$amount}");
                $this->addMessage('Bot', "Rate: ₦{$rate} per \$1");
                $this->addMessage('Bot', "Total: ₦" . number_format($nairaEquivalent, 2));
                $this->addMessage('Bot', "");
                $this->addMessage('Bot', "You will send ₦" . number_format($nairaEquivalent, 2) . " to our account details after confirmation. Do you want to proceed? (Type 'yes' to confirm or 'back' to go back)");
            } else if ($this->order->type == 'sell' && $this->order->asset == 'crypto') {
                $this->addMessage('Bot', "📋 ORDER SUMMARY");
                $this->addMessage('Bot', "Asset: {$asset->name}");
                $this->addMessage('Bot', "Amount: \${$amount}");
                $this->addMessage('Bot', "Rate: ₦{$rate} per \$1");
                $this->addMessage('Bot', "You'll receive: ₦" . number_format($nairaEquivalent, 2));
                $this->addMessage('Bot', "");
                $this->addMessage('Bot', "You will send \${$amount} worth of {$asset->name} to our wallet address after confirmation. Do you want to proceed? (Type 'yes' to confirm or 'back' to go back)");
            } else if ($this->order->type == 'buy' && $this->order->asset == 'giftcard') {
                $currency = $this->order->trade_currency ?? 'USD';
                $this->addMessage('Bot', "📋 ORDER SUMMARY");
                $this->addMessage('Bot', "Card: {$asset->name}");
                $this->addMessage('Bot', "Amount: {$currency} {$amount}");
                $this->addMessage('Bot', "USD Equivalent: \$" . number_format($dollarAmount, 2));
                $this->addMessage('Bot', "Rate: ₦{$rate} per \$1");
                $this->addMessage('Bot', "Total: ₦" . number_format($nairaEquivalent, 2));
                $this->addMessage('Bot', "");
                $this->addMessage('Bot', "You will send ₦" . number_format($nairaEquivalent, 2) . " to our account details after confirmation. Do you want to proceed? (Type 'yes' to confirm or 'back' to go back)");
            } else if ($this->order->type == 'sell' && $this->order->asset == 'giftcard') {
                $currency = $this->order->trade_currency ?? 'USD';
                $this->addMessage('Bot', "📋 ORDER SUMMARY");
                $this->addMessage('Bot', "Card: {$asset->name}");
                $this->addMessage('Bot', "Amount: {$currency} {$amount}");
                $this->addMessage('Bot', "USD Equivalent: \$" . number_format($dollarAmount, 2));
                $this->addMessage('Bot', "Rate: ₦{$rate} per \$1");
                $this->addMessage('Bot', "You'll receive: ₦" . number_format($nairaEquivalent, 2));
                $this->addMessage('Bot', "");
                $this->addMessage('Bot', "You will upload pictures of your gift card after confirmation. Do you want to proceed? (Type 'yes' to confirm or 'back' to go back)");
            }

            // Store all calculated values
            $this->order->asset_value = $amount;
            $this->order->dollar_price = $dollarAmount;
            $this->order->naira_price = $nairaEquivalent;
            
        } catch (Exception $e) {
            $this->addMessage('Bot', 'Sorry, there was an error calculating the exchange rate. Please try again or contact support.');
            return;
        }

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
            $path   = $result->getSecurePath();
            $url    = Storage::url($path);
            $fileUrl .= $url . ',';
        }

        $fileUrl               = rtrim($fileUrl, ',');
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
        $input = strtolower(trim($userInput));
        
        if ($input === 'yes' || $input === 'y' || $input === 'confirm') {
            $asset = $this->assetService->getAsset($this->order->asset_id);
            
            // Mark order as confirmed
            $this->order->transaction_status = 'confirmed';
            $this->order->confirmed_at = now();
            
            $this->addMessage('Bot', "✅ ORDER CONFIRMED!");
            $this->addMessage('Bot', "Order Reference: {$this->order->reference}");
            $this->addMessage('Bot', "");
            
            if ($this->order->type == 'buy' && $this->order->asset == 'crypto') {
                $this->addMessage('Bot', "💳 PAYMENT INSTRUCTIONS:");
                $this->addMessage('Bot', "Amount: ₦" . number_format($this->order->naira_price, 2));
                $this->addMessage('Bot', "Account: {$this->adminAccount?->account_number}");
                $this->addMessage('Bot', "Bank: {$this->adminAccount?->bank_name}");
                $this->addMessage('Bot', "Account Name: {$this->adminAccount?->account_name}");
                $this->addMessage('Bot', "Narration: {$this->order->reference}");
                $this->addMessage('Bot', "");
                $this->addMessage('Bot', "After payment, you'll receive \${$this->order->asset_value} worth of {$asset->name} in your wallet.");
                
            } else if ($this->order->type == 'sell' && $this->order->asset == 'crypto') {
                $this->addMessage('Bot', "💰 CRYPTO TRANSFER INSTRUCTIONS:");
                $this->addMessage('Bot', "Send \${$this->order->asset_value} worth of {$asset->name}");
                $this->addMessage('Bot', "To wallet: {$this->adminWallet?->crypto_wallet_number}");
                $this->addMessage('Bot', "");
                $this->addMessage('Bot', "After confirmation, you'll receive ₦" . number_format($this->order->naira_price, 2));
                
            } else if ($this->order->type == 'buy' && $this->order->asset == 'giftcard') {
                $this->addMessage('Bot', "💳 PAYMENT INSTRUCTIONS:");
                $this->addMessage('Bot', "Amount: ₦" . number_format($this->order->naira_price, 2));
                $this->addMessage('Bot', "Account: {$this->adminAccount?->account_number}");
                $this->addMessage('Bot', "Bank: {$this->adminAccount?->bank_name}");
                $this->addMessage('Bot', "Account Name: {$this->adminAccount?->account_name}");
                $this->addMessage('Bot', "Narration: {$this->order->reference}");
                $this->addMessage('Bot', "");
                $this->addMessage('Bot', "After payment, you'll receive your {$asset->name} gift card.");
                
            } else if ($this->order->type == 'sell' && $this->order->asset == 'giftcard') {
                $this->addMessage('Bot', "📱 GIFT CARD UPLOAD REQUIRED:");
                $this->addMessage('Bot', "Please upload clear pictures of both sides of your gift card.");
                $this->addMessage('Bot', "After verification, you'll receive ₦" . number_format($this->order->naira_price, 2));
                $this->step = 'upload_gift_card';
                $this->order->order_step = 'upload_gift_card';
            }
            
            $this->addMessage('Bot', "");
            $this->addMessage('Bot', "⚠️ IMPORTANT: This order expires in 24 hours without payment confirmation.");
            $this->addMessage('Bot', "📞 Need help? Contact our support team.");
            $this->addMessage('Bot', "🙏 Thank you for choosing TakersPay!");
            
        } else if ($input === 'no' || $input === 'n' || $input === 'cancel') {
            $this->order->transaction_status = 'canceled';
            $this->order->order_step = 'canceled';
            $this->addMessage('Bot', '❌ Order canceled successfully.');
            $this->addMessage('Bot', 'Type "start" to begin a new transaction.');
            $this->resetChat();
            
        } else if ($input === 'back') {
            // Back navigation is handled in the main handleInput method
            return;
            
        } else {
            $this->addMessage('Bot', 'Please type "yes" to confirm, "no" to cancel, or "back" to go back and modify your order.');
            return;
        }
        
        $this->order->save();
    }

    private function returnTodayRate()
    {
        $this->addMessage('Bot', "📊 Today's exchange rates:");
        $assets = Asset::all()->groupBy('type');
        
        if ($assets->has('crypto')) {
            $this->addMessage('Bot', "");
            $this->addMessage('Bot', "💰 CRYPTOCURRENCY:");
            foreach ($assets['crypto'] as $asset) {
                $this->addMessage('Bot', "{$asset->name}: Buy ₦{$asset->naira_buy_rate} | Sell ₦{$asset->naira_sell_rate}");
            }
        }
        
        if ($assets->has('giftcard')) {
            $this->addMessage('Bot', "");
            $this->addMessage('Bot', "🎁 GIFT CARDS:");
            foreach ($assets['giftcard'] as $asset) {
                $this->addMessage('Bot', "{$asset->name}: Buy ₦{$asset->naira_buy_rate} | Sell ₦{$asset->naira_sell_rate}");
            }
        }
        
        $this->addMessage('Bot', "");
        $this->addMessage('Bot', "Note: All rates are per $1 USD equivalent. Type 'start' to begin a transaction.");
    }

    /**
     * Find asset by user input (supports both numeric selection and text search)
     */
    private function findAssetByInput(string $userInput, AssetType $type): ?Asset
    {
        $input = trim(strtolower($userInput));
        
        // Get all assets of the specified type
        $assets = $this->assetService->getAssets($type);
        
        // Check if input is numeric (for numbered selection)
        if (is_numeric($input)) {
            $index = (int)$input - 1; // Convert to 0-based index
            if ($index >= 0 && $index < $assets->count()) {
                return $assets->values()[$index];
            }
        }
        
        // Search by name or slug (case insensitive)
        foreach ($assets as $asset) {
            if (strtolower($asset->name) === $input || 
                strtolower($asset->slug) === $input ||
                str_contains(strtolower($asset->name), $input) ||
                str_contains(strtolower($asset->slug), $input)) {
                return $asset;
            }
        }
        
        return null;
    }

    /**
     * Add back navigation functionality
     */
    private function handleBackNavigation(): bool
    {
        switch ($this->step) {
            case 'select_action':
                $this->handleUserFirstPrompt();
                return true;
                
            case 'select_currency':
                $this->step = 'select_action';
                $this->order->order_step = 'select_action';
                $this->addMessage('Bot', 'Going back... What would you like to do? (1: Buy Crypto, 2: Sell Crypto, 3: Buy Gift Card, 4: Sell Gift Card, 5: Reset Chat & Start Over)');
                return true;
                
            case 'select_gift_card':
                $this->step = 'select_action';
                $this->order->order_step = 'select_action';
                $this->addMessage('Bot', 'Going back... What would you like to do? (1: Buy Crypto, 2: Sell Crypto, 3: Buy Gift Card, 4: Sell Gift Card, 5: Reset Chat & Start Over)');
                return true;
                
            case 'select_trade_currency':
                $this->step = 'select_gift_card';
                $this->order->order_step = 'select_gift_card';
                $this->addMessage('Bot', "Going back... Which Card would you like to {$this->order->type}? ({$this->giftCardAssets})");
                return true;
                
            case 'enter_amount':
                if ($this->order->asset == 'crypto') {
                    $this->step = 'select_currency';
                    $this->order->order_step = 'select_currency';
                    $this->addMessage('Bot', "Going back... Which currency would you like to {$this->order->type}? ({$this->cryptoAssets})");
                } else {
                    $this->step = 'select_trade_currency';
                    $this->order->order_step = 'select_trade_currency';
                    $asset = $this->assetService->getAsset($this->order->asset_id);
                    $this->addMessage('Bot', "Going back... Choose the currency of the {$asset->name} card:");
                    $this->addMessage('Bot', "1: USD 🇺🇸  2: EUR 🇪🇺  3: GBP 🇬🇧  4: CAD 🇨🇦");
                    $this->addMessage('Bot', "5: AUD 🇦🇺  6: CNY 🇨🇳  7: JPY 🇯🇵  8: INR 🇮🇳");
                }
                return true;
                
            case 'confirm_purchase':
                $this->step = 'enter_amount';
                $this->order->order_step = 'enter_amount';
                if ($this->order->asset == 'crypto') {
                    $this->addMessage('Bot', "Going back... How much in US dollars would you like to {$this->order->type}? (Minimum: \$10)");
                } else {
                    $asset = $this->assetService->getAsset($this->order->asset_id);
                    $currency = $this->order->trade_currency ?? 'USD';
                    $this->addMessage('Bot', "Going back... How much worth of {$asset->name} in {$currency} would you like to {$this->order->type}? (Minimum: {$currency} 25)");
                }
                return true;
        }
        
        return false;
    }

    /**
     * Display asset options in a formatted way
     */
    private function displayAssetOptions(AssetType $type): void
    {
        $assets = $this->assetService->getAssets($type);
        $emoji = $type === AssetType::CRYPTO ? '₿' : '🎁';
        
        foreach ($assets as $index => $asset) {
            $number = $index + 1;
            $buyRate = number_format($asset->naira_buy_rate, 0);
            $sellRate = number_format($asset->naira_sell_rate, 0);
            $this->addMessage('Bot', "{$number}️⃣ {$emoji} {$asset->name} - Buy: ₦{$buyRate} | Sell: ₦{$sellRate}");
        }
        
        $this->addMessage('Bot', "");
        $this->addMessage('Bot', "💡 You can type the number or the name (e.g., '1' or 'Bitcoin')");
        $this->addMessage('Bot', "Type 'back' to go back or 'rates' for detailed rates");
    }

    /**
     * Show help information
     */
    private function showHelp(): void
    {
        $this->addMessage('Bot', "🆘 HELP & SUPPORT");
        $this->addMessage('Bot', "");
        $this->addMessage('Bot', "📋 Available Commands:");
        $this->addMessage('Bot', "• 'start' - Begin a new transaction");
        $this->addMessage('Bot', "• 'rates' - View current exchange rates");
        $this->addMessage('Bot', "• 'back' - Go to previous step");
        $this->addMessage('Bot', "• 'reset' - Start over completely");
        $this->addMessage('Bot', "• 'cancel' - Cancel current order");
        $this->addMessage('Bot', "• 'help' - Show this help menu");
        $this->addMessage('Bot', "");
        $this->addMessage('Bot', "💰 Transaction Limits:");
        $this->addMessage('Bot', "• Minimum crypto: $10");
        $this->addMessage('Bot', "• Minimum gift cards: $25 equivalent");
        $this->addMessage('Bot', "");
        $this->addMessage('Bot', "⏰ Processing Times:");
        $this->addMessage('Bot', "• Crypto: 5-15 minutes after payment");
        $this->addMessage('Bot', "• Gift cards: 10-30 minutes after verification");
        $this->addMessage('Bot', "");
        $this->addMessage('Bot', "📞 Need human support? Contact our team:");
        $this->addMessage('Bot', "• Email: support@takerspay.com");
        $this->addMessage('Bot', "• WhatsApp: +234-XXX-XXXX-XXX");
        $this->addMessage('Bot', "");
        $this->addMessage('Bot', "Type 'start' to begin a transaction!");
    }

    /**
     * Enhanced reset chat with better messaging
     */
    private function resetChat(): void
    {
        $this->messages[] = ['sender' => 'Bot', 'text' => '🔄 Chat reset successfully!', 'timestamp' => now()];
        $this->step = null;
        $this->data = [];
        
        // Clear order step but keep the order for reference
        if ($this->order) {
            $this->order->order_step = null;
            $this->order->save();
        }
    }

    /**
     * Enhanced cancel chat functionality
     */
    private function cancelChat(): void
    {
        if ($this->order) {
            $this->order->transaction_status = 'canceled';
            $this->order->order_step = 'canceled';
            $this->order->save();
        }
        
        $this->addMessage('Bot', '❌ Current order has been canceled.');
        $this->addMessage('Bot', 'Type "start" to begin a new transaction.');
        $this->step = null;
        $this->data = [];
    }
}
