<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Wallet>
 */
class WalletFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // Override to pass an existing user_id
            'type' => $this->faker->randomElement(['crypto', 'fiat']),
            'crypto_wallet_number' => $this->faker->uuid(),
            'account_number' => $this->faker->bankAccountNumber(),
            'bank_name' => $this->faker->company(),
            'account_name' => $this->faker->name(),
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
}
