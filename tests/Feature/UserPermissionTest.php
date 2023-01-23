<?php

namespace Tests\Feature;

use App\Classes\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserPermissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_is_allowed_permission(): void
    {
        $user = User::factory()->create([
            'role_id' => '1',
        ]);
        $this->actingAs($user);
        
        $permission = Role::checkPermission($user, 'users:read');
        
        $this->assertNull($permission);
    }

    public function test_user_is_denied_permission(): void
    {
        $user = User::factory()->create([
            'role_id' => '2',
        ]);
        $this->actingAs($user);
        
        $permission = Role::checkPermission($user, 'users:read');
        
        $this->assertNotNull($permission);
    }
}
