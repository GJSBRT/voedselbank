<?php

namespace Database\Factories;

use Carbon\Carbon;
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

        $createdAt = Carbon::createFromTimeStamp($date->getTimestamp());

        return [
            'supplier_id' => rand(1, 7),
            'expected_at' => $date,
            'delivered_at' => $date > now()? null : $date,
            'notes' => fake()->text,
            'created_at' => $createdAt->subDays(rand(1,10))
        ];
    }
}
