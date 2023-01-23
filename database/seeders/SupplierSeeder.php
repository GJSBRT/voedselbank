<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = [
            'Albert Heijn',
            'Jumbo',
            'Plus',
            'Action',
            'Coop',
            'Deen',
            'Spar',
            'Dirk',
        ];

        foreach ($companies as $company){
            Supplier::create([
                'company_name' => $company,
                'address' => fake()->streetAddress,
                'email' => fake()->companyEmail,
                'phone_number' => fake()->e164PhoneNumber,
                'contact_name' => fake()->name,
                'notes' => fake()->text,
            ]);
        }
    }
}
