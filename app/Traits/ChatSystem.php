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
        if (! isset($this->currencyService)) {
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

        $userInput   = trim($this->input);
        $this->input = '';                // Clear input immediately after capturing it
        $this->dispatch('input-cleared'); // Dispatch event to clear input in frontend

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
            // Clear data without showing error message
            $this->step = null;
            $this->data = [];
            if ($this->order) {
                $this->order->order_step = null;
                $this->order->save();
            }
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
        $this->step              = 'select_action';
        $this->order->order_step = 'select_action';

        $welcomeMessage = "🌟 **Welcome to TakersPay!**\n";
        $welcomeMessage .= "Your trusted platform for crypto and gift card transactions.\n\n";
        $welcomeMessage .= "**What would you like to do today?**\n\n";
        $welcomeMessage .= "1️⃣  Buy Cryptocurrency\n";
        $welcomeMessage .= "2️⃣  Sell Cryptocurrency\n";
        $welcomeMessage .= "3️⃣  Buy Gift Cards\n";
        $welcomeMessage .= "4️⃣  Sell Gift Cards\n";
        $welcomeMessage .= "📊  Check Today's Rates\n\n";
        $welcomeMessage .= "💡 **Tips:** You can type numbers (1-4) or commands like 'rates', 'help', or 'reset'";

        $this->addMessage('Bot', $welcomeMessage);
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
        $input                = strtolower(trim($userInput));
        $this->data['action'] = $input;

        if ($input == '1' || str_contains($input, 'buy') && str_contains($input, 'crypto')) {
            $this->step              = 'select_currency';
            $this->order->type       = 'buy';
            $this->order->asset      = AssetType::CRYPTO;
            $this->order->order_step = 'select_currency';

            $buyMessage = "💰 BUY CRYPTOCURRENCY\n";
            $buyMessage .= "Select the cryptocurrency you'd like to buy:\n\n";
            $this->addMessage('Bot', $buyMessage);
            $this->displayAssetOptions(AssetType::CRYPTO);

        } elseif ($input == '2' || str_contains($input, 'sell') && str_contains($input, 'crypto')) {
            $this->step              = 'select_currency';
            $this->order->type       = 'sell';
            $this->order->asset      = AssetType::CRYPTO;
            $this->order->order_step = 'select_currency';

            $sellMessage = "💸 SELL CRYPTOCURRENCY\n";
            $sellMessage .= "Select the cryptocurrency you'd like to sell:\n\n";
            $this->addMessage('Bot', $sellMessage);
            $this->displayAssetOptions(AssetType::CRYPTO);

        } elseif ($input == '3' || str_contains($input, 'buy') && str_contains($input, 'gift')) {
            $this->order->asset      = AssetType::GIFT_CARD;
            $this->order->type       = 'buy';
            $this->step              = 'select_gift_card';
            $this->order->order_step = 'select_gift_card';

            $buyGiftMessage = "🎁 BUY GIFT CARDS\n";
            $buyGiftMessage .= "Select the gift card you'd like to buy:\n\n";
            $this->addMessage('Bot', $buyGiftMessage);
            $this->displayAssetOptions(AssetType::GIFT_CARD);

        } elseif ($input == '4' || str_contains($input, 'sell') && str_contains($input, 'gift')) {
            $this->order->type       = 'sell';
            $this->order->asset      = AssetType::GIFT_CARD;
            $this->step              = 'select_gift_card';
            $this->order->order_step = 'select_gift_card';

            $sellGiftMessage = "💳 SELL GIFT CARDS\n";
            $sellGiftMessage .= "Select the gift card you'd like to sell:\n\n";
            $this->addMessage('Bot', $sellGiftMessage);
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
            $errorMessage = "❌ **Invalid option selected**\n\n";
            $errorMessage .= "**Please choose from:**\n";
            $errorMessage .= "• Numbers `1-4` for transactions\n";
            $errorMessage .= "• Type `rates` to check current rates\n";
            $errorMessage .= "• Type `help` for assistance\n";
            $errorMessage .= "• Type `reset` to start over";
            $this->addMessage('Bot', $errorMessage);
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

        if (! $asset) {
            $this->addMessage('Bot', 'Invalid option. Please select from the options above or type the asset name (e.g., "BTC" or "Bitcoin").');
            return;
        }

        $this->data['currency']  = $asset->slug;
        $this->step              = 'enter_amount';
        $this->order->order_step = 'enter_amount';
        $this->order->asset_id   = $asset->id;
        $this->order->asset      = AssetType::CRYPTO;

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

        if (! $asset) {
            $this->addMessage('Bot', 'Invalid option. Please select from the options above or type the card name (e.g., "Amazon" or "iTunes").');
            return;
        }

        $this->data['currency'] = $asset->slug;
        $this->order->asset_id  = $asset->id;
        $this->order->asset     = AssetType::GIFT_CARD;

        $currencyMessage = "Great choice! **Choose the currency of the {$asset->name} card:**\n\n";
        $currencyMessage .= "1️⃣  USD 🇺🇸    2️⃣  EUR 🇪🇺\n";
        $currencyMessage .= "3️⃣  GBP 🇬🇧    4️⃣  CAD 🇨🇦\n";
        $currencyMessage .= "5️⃣  AUD 🇦🇺    6️⃣  CNY 🇨🇳\n";
        $currencyMessage .= "7️⃣  JPY 🇯🇵    8️⃣  INR 🇮🇳\n\n";
        $currencyMessage .= "💡 **Options:** Type number, currency code, `back`, or `reset`";

        $this->addMessage('Bot', $currencyMessage);

        $this->step              = 'select_trade_currency';
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
            '5' => 'AUD', '6' => 'CNY', '7' => 'JPY', '8' => 'INR',
        ];

        // Also support direct currency code input
        $supportedCurrencies = ['USD', 'EUR', 'GBP', 'CAD', 'AUD', 'CNY', 'JPY', 'INR'];
        $upperInput          = strtoupper($input);

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
            $errorMessage = "❌ **Invalid currency selection**\n\n";
            $errorMessage .= "**Please choose from:**\n";
            $errorMessage .= "• Numbers `1-8` from the options above\n";
            $errorMessage .= "• Currency codes (e.g., `USD`, `EUR`)\n";
            $errorMessage .= "• Type `back` to go back\n";
            $errorMessage .= "• Type `reset` to start over";
            $this->addMessage('Bot', $errorMessage);
            return;
        }

        $asset    = $this->assetService->getAsset($this->order->asset_id);
        $currency = $this->order->trade_currency;

        // Validate if currency is supported by our service
        if (! $this->currencyService->isCurrencySupported($currency)) {
            $this->addMessage('Bot', "Sorry, {$currency} is not currently supported.");
            $this->addMessage('Bot', 'Please select from the available options above.');
            return;
        }

        $this->step              = 'enter_amount';
        $this->order->order_step = 'enter_amount';

        $currencySymbol = $this->currencyService->formatCurrency(0, $currency);
        $currencySymbol = str_replace('0.00', '', $currencySymbol); // Get just the symbol

        $amountMessage = "💱 Currency selected: {$currency}\n\n";
        $amountMessage .= "How much worth of {$asset->name} in {$currency} would you like to {$this->order->type}?\n\n";
        $amountMessage .= "💡 Minimum amount: {$currencySymbol}25\n";
        $amountMessage .= "💡 Enter amount without currency symbol (e.g., just type '100')";

        $this->addMessage('Bot', $amountMessage);

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
        $asset                = $this->assetService->getAsset($this->order->asset_id);

        if (! $asset) {
            $this->addMessage('Bot', 'Sorry, this asset is not available. Please restart the chat.');
            $this->resetChat();
            return;
        }

        try {
            // Calculate naira equivalent based on asset type
            if ($this->order->asset == 'crypto') {
                $nairaEquivalent = $this->currencyService->calculateCryptoNairaEquivalent($amount, $asset, $this->order->type);
                $dollarAmount    = $amount;
            } else {
                $currency        = $this->order->trade_currency ?? 'USD';
                $nairaEquivalent = $this->currencyService->calculateGiftCardNairaEquivalent($amount, $currency, $asset, $this->order->type);
                $dollarAmount    = $this->currencyService->convertCurrency($amount, $currency, 'USD');
            }

            // Get the rate used for calculation (matches CurrencyService logic)
            $rate = $this->order->type == 'buy' ? $asset->naira_sell_rate : $asset->naira_buy_rate;

            $this->step              = 'confirm_purchase';
            $this->order->order_step = 'confirm_purchase';

            // Generate confirmation messages with better formatting
            $summaryMessage = "📋 ORDER SUMMARY\n\n";

            if ($this->order->type == 'buy' && $this->order->asset == 'crypto') {
                $summaryMessage .= "Asset: {$asset->name}\n";
                $summaryMessage .= "Amount: \${$amount}\n";
                $summaryMessage .= "Rate: ₦{$rate} per \$1\n";
                $summaryMessage .= "Total: ₦" . number_format($nairaEquivalent, 2) . "\n\n";
                $summaryMessage .= "Credit your fundspadi account with ₦" . number_format($nairaEquivalent, 2) . " 👉 fundspadi.com\n";
                $summaryMessage .= "— Crypto goes to your wallet.\n\n";
                $summaryMessage .= "Do you want to proceed? (Type 'yes' to confirm or 'back' to go back)";

            } else if ($this->order->type == 'sell' && $this->order->asset == 'crypto') {
                $summaryMessage .= "Asset: {$asset->name}\n";
                $summaryMessage .= "Amount: \${$amount}\n";
                $summaryMessage .= "Rate: ₦{$rate} per \$1\n";
                $summaryMessage .= "You'll receive: ₦" . number_format($nairaEquivalent, 2) . "\n\n";
                $summaryMessage .= "You will send \${$amount} worth of {$asset->name} to our wallet address after confirmation. Do you want to proceed? (Type 'yes' to confirm or 'back' to go back)";

            } else if ($this->order->type == 'buy' && $this->order->asset == 'giftcard') {
                $currency = $this->order->trade_currency ?? 'USD';
                $summaryMessage .= "Card: {$asset->name}\n";
                $summaryMessage .= "Amount: {$currency} {$amount}\n";
                $summaryMessage .= "USD Equivalent: \$" . number_format($dollarAmount, 2) . "\n";
                $summaryMessage .= "Rate: ₦{$rate} per \$1\n";
                $summaryMessage .= "Total: ₦" . number_format($nairaEquivalent, 2) . "\n\n";
                $summaryMessage .= "Credit your fundspadi account with ₦" . number_format($nairaEquivalent, 2) . " 👉 fundspadi.com\n";
                $summaryMessage .= "— Giftcards sent by email.\n\n";
                $summaryMessage .= "Do you want to proceed? (Type 'yes' to confirm or 'back' to go back)";

            } else if ($this->order->type == 'sell' && $this->order->asset == 'giftcard') {
                $currency = $this->order->trade_currency ?? 'USD';
                $summaryMessage .= "Card: {$asset->name}\n";
                $summaryMessage .= "Amount: {$currency} {$amount}\n";
                $summaryMessage .= "USD Equivalent: \$" . number_format($dollarAmount, 2) . "\n";
                $summaryMessage .= "Rate: ₦{$rate} per \$1\n";
                $summaryMessage .= "You'll receive: ₦" . number_format($nairaEquivalent, 2) . "\n\n";
                $summaryMessage .= "You will upload pictures of your gift card after confirmation. Do you want to proceed? (Type 'yes' to confirm or 'back' to go back)";
            }

            $this->addMessage('Bot', $summaryMessage);

            // Store all calculated values
            $this->order->asset_value  = $amount;
            $this->order->dollar_price = $dollarAmount;
            $this->order->naira_price  = $nairaEquivalent;
            

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
            $this->order->confirmed_at       = now();

            $confirmationMessage = "✅ ORDER CONFIRMED!\n";
            $confirmationMessage .= "Order Reference: {$this->order->reference}\n\n";

            if ($this->order->type == 'buy' && $this->order->asset == 'crypto') {
                $confirmationMessage .= "💳 PAYMENT INSTRUCTIONS:\n";
                $confirmationMessage .= "Amount: ₦" . number_format($this->order->naira_price, 2) . "\n";
                $confirmationMessage .= "Platform: FundsPadi Account 👉 fundspadi.com\n";
                $confirmationMessage .= "Note: Funds will be deducted automatically from your FundsPadi wallet\n";
                $confirmationMessage .= "Reference: {$this->order->reference}\n\n";
                $confirmationMessage .= "After payment, you'll receive \${$this->order->asset_value} worth of {$asset->name} in your wallet.\n\n";

            } else if ($this->order->type == 'sell' && $this->order->asset == 'crypto') {
                $confirmationMessage .= "💰 CRYPTO TRANSFER INSTRUCTIONS:\n";
                $confirmationMessage .= "Send \${$this->order->asset_value} worth of {$asset->name}\n";
                $confirmationMessage .= "To wallet: {$this->adminWallet?->crypto_wallet_number}\n\n";
                $confirmationMessage .= "After confirmation, you'll receive ₦" . number_format($this->order->naira_price, 2) . "\n\n";

            } else if ($this->order->type == 'buy' && $this->order->asset == 'giftcard') {
                $confirmationMessage .= "💳 PAYMENT INSTRUCTIONS:\n";
                $confirmationMessage .= "Amount: ₦" . number_format($this->order->naira_price, 2) . "\n";
                $confirmationMessage .= "Platform: FundsPadi Account 👉 fundspadi.com\n";
                $confirmationMessage .= "Note: Funds will be deducted automatically from your FundsPadi wallet\n";
                $confirmationMessage .= "Reference: {$this->order->reference}\n\n";
                $confirmationMessage .= "After payment, you'll receive your {$asset->name} gift card.\n\n";

            } else if ($this->order->type == 'sell' && $this->order->asset == 'giftcard') {
                $confirmationMessage .= "📱 GIFT CARD UPLOAD REQUIRED:\n";
                $confirmationMessage .= "Please upload clear pictures of both sides of your gift card.\n";
                $confirmationMessage .= "After verification, you'll receive ₦" . number_format($this->order->naira_price, 2) . "\n\n";
                $this->step              = 'upload_gift_card';
                $this->order->order_step = 'upload_gift_card';
            }

            $confirmationMessage .= "⚠️ IMPORTANT: This order expires in 24 hours without payment confirmation.\n";
            $confirmationMessage .= "📞 Need help? Contact our support team.\n";
            $confirmationMessage .= "🙏 Thank you for choosing TakersPay!";

            $this->addMessage('Bot', $confirmationMessage);

        } else if ($input === 'no' || $input === 'n' || $input === 'cancel') {
            $this->order->transaction_status = 'canceled';
            $this->order->order_step         = 'canceled';
            $cancelMessage                   = "❌ Order canceled successfully.\n";
            $cancelMessage .= 'Type "start" to begin a new transaction.';
            $this->addMessage('Bot', $cancelMessage);
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
        $rateMessage = "📊 **TODAY'S EXCHANGE RATES**\n\n";
        $assets      = Asset::where('is_active', true)->get()->groupBy('type');

        if ($assets->has('crypto')) {
            $rateMessage .= "💰 **CRYPTOCURRENCY**\n";
            $rateMessage .= "──────────────────────\n";
            foreach ($assets['crypto'] as $asset) {
                $buyRate  = number_format($asset->naira_buy_rate, 0);
                $sellRate = number_format($asset->naira_sell_rate, 0);
                $rateMessage .= "🔸 **{$asset->name}**\n";
                $rateMessage .= "   We Buy:  ₦{$sellRate}  |  We Sell: ₦{$buyRate}\n\n";
            }
        }

        if ($assets->has('giftcard')) {
            $rateMessage .= "🎁 **GIFT CARDS**\n";
            $rateMessage .= "──────────────────────\n";
            foreach ($assets['giftcard'] as $asset) {
                $buyRate  = number_format($asset->naira_buy_rate, 0);
                $sellRate = number_format($asset->naira_sell_rate, 0);
                $rateMessage .= "🔸 **{$asset->name}**\n";
                $rateMessage .= "   We Buy:  ₦{$sellRate}  |  We Sell: ₦{$buyRate}\n\n";
            }
        }

        $rateMessage .= "💡 **Note:** All rates per \$1 USD equivalent";

        $this->addMessage('Bot', $rateMessage);
        $this->addMessage('Bot', "🚀 Type 'start' to begin a transaction");
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
            $index = (int) $input - 1; // Convert to 0-based index
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
                $this->step              = 'select_action';
                $this->order->order_step = 'select_action';
                $this->addMessage('Bot', 'Going back... What would you like to do? (1: Buy Crypto, 2: Sell Crypto, 3: Buy Gift Card, 4: Sell Gift Card, 5: Reset Chat & Start Over)');
                return true;

            case 'select_gift_card':
                $this->step              = 'select_action';
                $this->order->order_step = 'select_action';
                $this->addMessage('Bot', 'Going back... What would you like to do? (1: Buy Crypto, 2: Sell Crypto, 3: Buy Gift Card, 4: Sell Gift Card, 5: Reset Chat & Start Over)');
                return true;

            case 'select_trade_currency':
                $this->step              = 'select_gift_card';
                $this->order->order_step = 'select_gift_card';
                $this->addMessage('Bot', "Going back... Which Card would you like to {$this->order->type}? ({$this->giftCardAssets})");
                return true;

            case 'enter_amount':
                if ($this->order->asset == 'crypto') {
                    $this->step              = 'select_currency';
                    $this->order->order_step = 'select_currency';
                    $this->addMessage('Bot', "Going back... Which currency would you like to {$this->order->type}? ({$this->cryptoAssets})");
                } else {
                    $this->step              = 'select_trade_currency';
                    $this->order->order_step = 'select_trade_currency';
                    $asset                   = $this->assetService->getAsset($this->order->asset_id);

                    $backMessage = "Going back... Choose the currency of the {$asset->name} card:\n\n";
                    $backMessage .= "1: USD 🇺🇸  2: EUR 🇪🇺  3: GBP 🇬🇧  4: CAD 🇨🇦\n";
                    $backMessage .= "5: AUD 🇦🇺  6: CNY 🇨🇳  7: JPY 🇯🇵  8: INR 🇮🇳";
                    $this->addMessage('Bot', $backMessage);
                }
                return true;

            case 'confirm_purchase':
                $this->step              = 'enter_amount';
                $this->order->order_step = 'enter_amount';
                if ($this->order->asset == 'crypto') {
                    $this->addMessage('Bot', "Going back... How much in US dollars would you like to {$this->order->type}? (Minimum: \$10)");
                } else {
                    $asset    = $this->assetService->getAsset($this->order->asset_id);
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
        $emoji  = $type === AssetType::CRYPTO ? '₿' : '🎁';

        $message = "";
        foreach ($assets as $index => $asset) {
            $number   = $index + 1;
            $buyRate  = number_format($asset->naira_buy_rate, 0);
            $sellRate = number_format($asset->naira_sell_rate, 0);
            $message .= "{$number}️⃣  {$emoji} **{$asset->name}**\n";
            $message .= "    We Buy: ₦{$sellRate}  |  We Sell: ₦{$buyRate}\n\n";
        }

        $message .= "💡 **Tips:**\n";
        $message .= "• Type the number (e.g., '1') or name (e.g., 'Bitcoin')\n";
        $message .= "• Type 'back' to go back or 'rates' for detailed rates";

        $this->addMessage('Bot', $message);
    }

    /**
     * Show help information
     */
    private function showHelp(): void
    {
        $helpMessage = "🆘 **HELP & SUPPORT**\n\n";
        $helpMessage .= "**📋 Available Commands:**\n";
        $helpMessage .= "• `start` - Begin a new transaction\n";
        $helpMessage .= "• `rates` - View current exchange rates\n";
        $helpMessage .= "• `back` - Go to previous step\n";
        $helpMessage .= "• `reset` - Start over completely\n";
        $helpMessage .= "• `cancel` - Cancel current order\n";
        $helpMessage .= "• `help` - Show this help menu\n\n";
        $helpMessage .= "**💰 Transaction Limits:**\n";
        $helpMessage .= "• Minimum crypto: \$10\n";
        $helpMessage .= "• Minimum gift cards: \$25 equivalent\n\n";
        $helpMessage .= "**⏰ Processing Times:**\n";
        $helpMessage .= "• Crypto: 5-15 minutes after payment\n";
        $helpMessage .= "• Gift cards: 10-30 minutes after verification\n\n";
        $helpMessage .= "**📞 Need human support?**\n";
        $helpMessage .= "• Email: support@takerspay.com\n";
        $helpMessage .= "• WhatsApp: +234-XXX-XXXX-XXX";

        $this->addMessage('Bot', $helpMessage);
        $this->addMessage('Bot', "🚀 Type 'start' to begin a transaction!");
    }

    /**
     * Enhanced reset chat with better messaging
     */
    private function resetChat(): void
    {
        $this->messages[] = ['sender' => 'Bot', 'text' => '🔄 Chat reset successfully!', 'timestamp' => now()];
        $this->step       = null;
        $this->data       = [];

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
            $this->order->order_step         = 'canceled';
            $this->order->save();
        }

        $cancelMessage = "❌ Current order has been canceled.\n";
        $cancelMessage .= 'Type "start" to begin a new transaction.';
        $this->addMessage('Bot', $cancelMessage);
        $this->step = null;
        $this->data = [];
    }
}
