<?php
namespace App\Services;

use App\Models\Asset;
use App\Models\ExchangeRate;
use Exception;

class CurrencyService
{
    /**
     * Exchange rates for different currencies to USD
     * These should ideally come from an external API
     */
    private const DEFAULT_EXCHANGE_RATES = [
        'USD' => 1.0,
        'EUR' => 1.09,
        'GBP' => 1.27,
        'CAD' => 0.74,
        'AUD' => 0.66,
        'CNY' => 0.14,
        'JPY' => 0.0067,
        'INR' => 0.012,
    ];

    /**
     * Convert an amount from one currency to another
     */
    public function convertCurrency(float $amount, string $fromCurrency, string $toCurrency): float
    {
        if ($fromCurrency === $toCurrency) {
            return $amount;
        }

        // Get current exchange rates
        $rates = $this->getCurrentExchangeRates();
        
        if (!isset($rates[$fromCurrency]) || !isset($rates[$toCurrency])) {
            throw new Exception("Exchange rate not available for {$fromCurrency} to {$toCurrency}");
        }

        // Convert from source currency to USD, then to target currency
        // Rates represent how much USD you get for 1 unit of foreign currency
        if ($fromCurrency === 'USD') {
            $usdAmount = $amount;
        } else {
            $usdAmount = $amount * $rates[$fromCurrency];
        }
        
        if ($toCurrency === 'USD') {
            return $usdAmount;
        } else {
            return $usdAmount / $rates[$toCurrency];
        }
    }

    /**
     * Calculate naira equivalent for crypto transactions
     */
    public function calculateCryptoNairaEquivalent(float $dollarAmount, Asset $asset, string $transactionType): float
    {
        // Fix the rate logic: 
        // When user BUYS crypto, they pay naira at the platform's sell rate
        // When user SELLS crypto, they receive naira at the platform's buy rate
        $rate = $transactionType === 'buy' ? $asset->naira_sell_rate : $asset->naira_buy_rate;
        
        return $dollarAmount * $rate;
    }

    /**
     * Calculate naira equivalent for gift card transactions
     */
    public function calculateGiftCardNairaEquivalent(float $amount, string $currency, Asset $asset, string $transactionType): float
    {
        // Convert gift card currency to USD first
        $dollarAmount = $this->convertCurrency($amount, $currency, 'USD');
        
        // Then calculate naira equivalent using asset rates
        $rate = $transactionType === 'buy' ? $asset->naira_sell_rate : $asset->naira_buy_rate;
        
        return $dollarAmount * $rate;
    }

    /**
     * Get current exchange rates (from cache or external API)
     */
    public function getCurrentExchangeRates(): array
    {
        // In a real application, this would fetch from an external API
        // For now, return default rates
        return self::DEFAULT_EXCHANGE_RATES;
    }

    /**
     * Store exchange rate for historical tracking
     */
    public function storeExchangeRate(string $fromCurrency, string $toCurrency, float $rate): void
    {
        // This would store in the exchange_rates table
        // Implementation depends on the database schema we'll create
    }

    /**
     * Format currency amount for display
     */
    public function formatCurrency(float $amount, string $currency): string
    {
        $symbols = [
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'CAD' => 'C$',
            'AUD' => 'A$',
            'CNY' => '¥',
            'JPY' => '¥',
            'INR' => '₹',
            'NGN' => '₦',
        ];

        $symbol = $symbols[$currency] ?? $currency;
        return $symbol . number_format($amount, 2);
    }

    /**
     * Get supported currencies
     */
    public function getSupportedCurrencies(): array
    {
        return array_keys(self::DEFAULT_EXCHANGE_RATES);
    }

    /**
     * Validate if currency is supported
     */
    public function isCurrencySupported(string $currency): bool
    {
        return array_key_exists($currency, self::DEFAULT_EXCHANGE_RATES);
    }
}