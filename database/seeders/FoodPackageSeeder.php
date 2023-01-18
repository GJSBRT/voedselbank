<?php

namespace Database\Seeders;

use App\Models\FoodPackage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FoodPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 500; $i++) {
            $date = fake()->dateTimeBetween('-1week', '+1week');

            $foodpackage = FoodPackage::create([
                'customer_id' => rand(1, 100),
                'notes' => fake()->text,
                'retrieved_at' => $date > now() ? null : $date,
            ]);

            for ($j = 1; $j < rand(1, 20); $j++) {
                $foodpackage->addItem(rand(1, 100));
            }
        }
    }
}
