<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserMetaData>
 */
class UserMetaDataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'tag' => $this->faker->word(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'profile_image' => $this->faker->imageUrl(200, 200, 'people'),
            'email_verified_at' => $this->faker->boolean() ? now() : null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
