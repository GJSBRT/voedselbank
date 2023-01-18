<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Delivery>
 */
class DeliveryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition()
    {
        $date = fake()->dateTimeBetween('-1week', '+1week');

        return [
            'supplier_id' => rand(1, 10),
            'expected_at' => $date,
            'delivered_at' => $date > now()? null : $date,
            'notes' => fake()->text,
        ];
    }
}
