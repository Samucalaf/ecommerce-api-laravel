<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    
    public function definition(): array
    {
        return [
            'owner' => "Samuel Lafuente",
            'street' => fake()->streetAddress(),
            'number' => fake()->buildingNumber(),
            'complement' => fake()->optional()->secondaryAddress(),
            'neighborhood' => fake()->citySuffix(),
            'city' => fake()->city(),
            'federation_unit' => fake()->stateAbbr(),
            'zip_code' => substr(preg_replace('/\D/', '', fake()->postcode()), 0, 8),
            'user_id' => 1,
        ];
    }
}
