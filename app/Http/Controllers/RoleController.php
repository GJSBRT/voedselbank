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

    public function view(Request $request, int $roleId)
    {
        $permission = ClassRole::checkPermission($request->user(), 'roles:read');
        if ($permission) { return $permission; }

        return Inertia::render('Roles/View', [
            'role' => Role::find($roleId),
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

    public function update(Request $request, int $roleId)
    {
        $permission = ClassRole::checkPermission($request->user(), 'roles:update');
        if ($permission) { return $permission; }

        $role = Role::find($roleId);
        $role->name = $request->input('name');
        $role->permissions = $request->input('permissions');
        $role->save();

        return redirect()->route('roles.index')->banner("De rol {$role->name} is successvol aangepast!");
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
