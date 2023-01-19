<?php

namespace App\Http\Controllers;

use App\Classes\Role as ClassRole;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RoleController extends Controller
{
    public function index() 
    {
        return Inertia::render('Roles/Show', [
            'roles' => Role::paginate(),
        ]);
    }
    
    public function new() 
    {
        return Inertia::render('Roles/New',[
            'available_permissions' => ClassRole::$permissions,
        ]);
    }
    
    public function view(int $roleId) 
    {
        return Inertia::render('Roles/View', [
            'role' => Role::find($roleId),
            'available_permissions' => ClassRole::$permissions,
        ]);
    }

    public function create(Request $request) 
    {
        $name = $request->input('name');
        $permissions = $request->input('permissions');

        $request->validate([
            'name' => 'required|string|max:100',
            'permissions' => 'required|array',
        ]);

        Role::create([
            'name' => $name,
            'permissions' => $permissions,
        ]);

        return redirect()->route('roles.index')->banner("De rol {$name} is successvol toegevoeged!");
    }

    public function update(Request $request, int $roleId) 
    {
        $role = Role::find($roleId);
        $newRole = $request->input('role');

        $role->name = $newRole['name'];
        $role->permissions = $newRole['permissions'];
        $role->save();

        return redirect()->route('roles.index')->banner("De rol {$role->name} is successvol aangepast!");
    }
}
