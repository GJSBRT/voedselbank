<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CustomerSeeder::class,
            ProductCategorySeeder::class,
            ProductSeeder::class,
            FoodPackageSeeder::class,
            SupplierSeeder::class,
            DeliverySeeder::class,
        ]);
    }
}
