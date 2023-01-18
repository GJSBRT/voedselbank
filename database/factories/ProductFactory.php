<?php

namespace Database\Factories;

use FakerRestaurant\Provider\en_US\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $faker = \Faker\Factory::create();
        $faker->addProvider(new Restaurant($faker));

        $products = [
            $faker->foodName(),
            $faker->beverageName(),
            $faker->dairyName(),
            $faker->vegetableName(),
            $faker->fruitName(),
            $faker->meatName(),
        ];

        $number = rand(0,5);

        return [
            'name' => $products[$number],
            'ean_number' => fake()->ean13(),
            'product_category_id' => $number + 1,
            'quantity' => rand(0, 200),
        ];
    }
}
