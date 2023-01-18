<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductCategory::create([
            'name' => 'Voedsel',
        ]);

        ProductCategory::create([
            'name' => 'Drinken',
        ]);

        ProductCategory::create([
            'name' => 'Zuivel',
        ]);

        ProductCategory::create([
            'name' => 'Groente',
        ]);

        ProductCategory::create([
            'name' => 'Fruit',
        ]);

        ProductCategory::create([
            'name' => 'Vlees',
        ]);
    }
}
