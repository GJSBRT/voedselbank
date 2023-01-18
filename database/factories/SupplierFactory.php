<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'company_name' => fake()->company,
            'address' => fake()->streetAddress,
            'email' => fake()->companyEmail,
            'phone_number' => fake()->e164PhoneNumber,
            'contact_name' => fake()->name,
            'notes' => fake()->text,
        ];
    }
}
