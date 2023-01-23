<?php

namespace App\Classes;

use App\Models\User;

class Role {

    /**
     * All permissions available
     * 
     * @var array
     */
    public static $permissions = [
        '*', // All permissions
        'food-packages:create',
        'food-packages:write',
        'food-packages:delete',
        'food-packages:update',
        'users:read',
        'users:create',
        'users:delete',
        'users:update',
        'roles:read',
        'roles:create',
        'roles:delete',
        'roles:update',
        'suppliers:read',
        'suppliers:create',
        'suppliers:delete',
        'suppliers:update',
        'deliveries:read',
        'deliveries:create',
        'deliveries:delete',
        'deliveries:update',
    ];
    
    /**
     * Check if user has permission
     * 
     * @param User $user
     * @param string $permission
     * @return redirect
     */
    public static function checkPermission(User $user, string $permission) {
        $userPermissions = json_decode($user->role->permissions);

        if (!in_array('*', $userPermissions)) {
            if (!in_array($permission, $userPermissions)) {
                return redirect()->route('dashboard')->dangerBanner('Je hebt geen toegang tot deze pagina!');
            }
        }
    }
}