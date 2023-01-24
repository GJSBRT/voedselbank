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
        'food-packages:read',
        'food-packages:create',
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
        'customers:read',
        'customers:create',
        'customers:delete',
        'customers:update',
        'categories:read',
        'categories:create',
        'categories:update',
        'categories:delete',
        'products:read',
        'products:create',
        'products:update',
        'products:delete',
        ];

    /**
     * Check if user has permission
     *
     * @param User $user
     * @param string $permission
     * @param bool $redirect
     * @return redirect
     */
    public static function checkPermission(User $user, string $permission, $redirect = true) {
        $userPermissions = json_decode($user->role->permissions);

        if (!in_array('*', $userPermissions)) {
            if (!in_array($permission, $userPermissions)) {
                if ($redirect) {
                    return redirect()->route('dashboard')->dangerBanner('Je hebt geen toegang tot deze pagina!');
                } else {
                    return false;
                }
            }
        }

        if (!$redirect) {
            return true;
        }
    }
}
