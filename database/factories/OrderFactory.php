<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // This can be overridden to use an existing user
            'wallet_id' => Wallet::factory(), // This can be overridden to use an existing wallet
            'reference' => strtoupper($this->faker->lexify('ORD??????')),
            'type' => $this->faker->randomElement(['buy', 'sell']),
            'asset' => $this->faker->randomElement(['crypto', 'card']),
            'asset_value' => $this->faker->randomFloat(2, 10, 1000),
            'dollar_price' => $this->faker->randomFloat(2, 10, 1000),
            'naira_price' => $this->faker->randomFloat(2, 5000, 500000),
            'transaction_status' => $this->faker->randomElement(['pending', 'completed', 'canceled']),
            'file_url' => $this->faker->imageUrl(),
            'confirmed_at' => $this->faker->boolean() ? now() : null,
            'fulfilled_at' => $this->faker->boolean() ? now() : null,
        ];
    }
}
