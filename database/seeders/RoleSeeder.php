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
                'food-packages:create',
                'food-packages:write',
                'food-packages:delete',
                'food-packages:update',
            ]),
        ]);
    }
}
