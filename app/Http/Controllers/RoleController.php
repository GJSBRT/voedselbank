<?php

namespace App\Http\Controllers;

use App\Classes\Role as ClassRole;
use App\Http\Requests\CreateRoleRequest;
use App\Models\Role;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Searchable\Search;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $permission = ClassRole::checkPermission($request->user(), 'roles:read');
        if ($permission) { return $permission; }

        return Inertia::render('Roles/Show', [
            'roles' => Role::with('users')->paginate(),
        ]);
    }

    public function new(Request $request)
    {
        $permission = ClassRole::checkPermission($request->user(), 'roles:create');
        if ($permission) { return $permission; }

        return Inertia::render('Roles/New',[
            'available_permissions' => ClassRole::$permissions,
        ]);
    }

    public function view(Request $request, $roleId)
    {
        $permission = ClassRole::checkPermission($request->user(), 'roles:read');
        if ($permission) { return $permission; }

        // Try to get the role, else gives a 404 back instead of a 500 error.
        $role = Role::where('id', $roleId)->firstOrFail();

        return Inertia::render('Roles/View', [
            'role' => $role,
            'available_permissions' => ClassRole::$permissions,
        ]);
    }

    public function create(CreateRoleRequest $request)
    {
        $permission = ClassRole::checkPermission($request->user(), 'roles:create');
        if ($permission) { return $permission; }

        $name = $request->input('name');
        $permissions = $request->input('permissions');

        Role::create([
            'name' => $name,
            'permissions' => json_encode($permissions),
        ]);

        return redirect()->route('roles.index')->banner("De rol {$name} is successvol toegevoeged!");
    }

    public function update(Request $request, $roleId)
    {
        $permission = ClassRole::checkPermission($request->user(), 'roles:update');
        if ($permission) { return $permission; }

        // Try to get the role, else gives a 404 back instead of a 500 error.
        $role = Role::where('id', $roleId)->firstOrFail();

        $role->name = $request->input('name');
        $role->permissions = $request->input('permissions');
        $role->save();

        return redirect()->route('roles.index')->banner("De rol {$role->name} is successvol aangepast!");
    }
    
    public function delete(Request $request, $roleId)
    {
        $permission = ClassRole::checkPermission($request->user(), 'roles:delete');
        if ($permission) { return $permission; }
        // Try to get the role, else gives a 404 back instead of a 500 error.
        $role = Role::where('id', $roleId)->with('users')->firstOrFail();

        
        if (count($role->users) > 0) {
            return redirect()->route('roles.index')->dangerBanner("De rol {$role->name} kan niet verwijdered worden omdat er nog gebruikers aan gekoppeld zijn!");
        }

        $role->delete();

        return redirect()->route('roles.index')->banner("De rol {$role->name} is successvol verwijdered!");
    }

    public function search(Request $request)
    {
        $permission = ClassRole::checkPermission($request->user(), 'roles:read');
        if ($permission) { return $permission; }

        $results = (new Search())
            ->registerModel(Role::class, ['name'])
            ->search($request->input('query'));

        return response()->json($results);
    }
}
