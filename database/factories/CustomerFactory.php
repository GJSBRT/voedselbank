<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'firstname' => fake()->firstName,
            'lastname' => fake()->lastName,
            'phone_number' => fake()->e164PhoneNumber,
            'email' => fake()->email,
            'address' => fake()->streetAddress,
            'adult_amount' => rand(1, 3),
            'child_amount' => rand(0, 6),
            'baby_amount' => rand(0, 2),
            'notes' => fake()->text
        ];
    }
}
