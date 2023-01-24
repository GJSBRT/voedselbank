<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'id' => 1,
            'name' => 'directie',
            'permissions' => json_encode(['*']),
        ]);

        Role::create([
            'id' => 2,
            'name' => 'magazijnmedewerker',
            'permissions' => json_encode([
                'customers:read',
                'products:read',
                'products:create',
                'products:update',
                'suppliers:read',
                'suppliers:create',
                'suppliers:delete',
                'suppliers:update',
                'deliveries:read',
                'deliveries:create',
                'deliveries:delete',
                'deliveries:update',
            ]),
        ]);

        Role::create([
            'id' => 3,
            'name' => 'vrijwilliger',
            'permissions' => json_encode([
                'customers:read',
                'products:read',
                'food-packages:read',
                'food-packages:create',
                'food-packages:delete',
                'food-packages:update',
                'products:read',
                'products:update',
            ]),
        ]);
    }
}
