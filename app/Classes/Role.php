<?php

namespace App\Classes;

use App\Models\User;

class Role {
    
    /**
     * Check if user has permission
     * 
     * @param User $user
     * @param string $permission
     * @return bool
     */
    public static function checkPermission(User $user, string $permission): bool {
        $userRoles = $user->roles;

        foreach($userRoles as $role) {
            if (in_array($permission, $role->permissions)) {
                return true;
            }
        }

        return false;
    }
}