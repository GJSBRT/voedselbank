<?php

namespace App\Http\Controllers;

use App\Classes\Role;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Inertia\Inertia;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $permission = Role::checkPermission($request->user(), 'users:read');
        if ($permission) { return $permission; }

        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query
                        ->orWhere('first_name', 'LIKE', "%{$value}%")
                        ->orWhere('email', 'LIKE', "%{$value}%");
                });
            });
        });

        $users = QueryBuilder::for(User::class)
            ->allowedSorts(['created_at'])
            ->allowedFilters(['first_name', 'email', $globalSearch])
            ->paginate()
            ->withQueryString();

        return Inertia::render('Users/Show', [
            'users' => $users,
        ]);
    }

    public function new(Request $request)
    {
        $permission = Role::checkPermission($request->user(), 'users:write');
        if ($permission) { return $permission; }

        return Inertia::render('Users/New');
    }

    public function view(Request $request, $userId)
    {
        $permission = Role::checkPermission($request->user(), 'users:read');
        if ($permission) { return $permission; }

        // Try to get the user, else gives a 404 back instead of a 500 error.
        $user = User::with('role')->where('id', $userId)->firstOrFail();

        return Inertia::render('Users/View', [
            'user' => $user,
            'two_factor_enabled' => $user->two_factor_confirmed_at ? true : false,
            'suspended' => $user->suspended_at ? true : false,
        ]);
    }

    public function create(CreateUserRequest $request)
    {
        $permission = Role::checkPermission($request->user(), 'users:create');
        if ($permission) { return $permission; }

        $firstName = $request->input('first_name');
        $lastName = $request->input('last_name');
        $email = $request->input('email');
        $password = $request->input('password');
        $role_id = $request->input('role_id');

        User::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'password' => bcrypt($password),
            'role_id' => $role_id,
        ]);

        return redirect()->route('users.index')->banner("{$firstName} is successvol toegevoeged als medewerker!");
    }

    public function update(UpdateUserRequest $request, $userId)
    {
        $permission = Role::checkPermission($request->user(), 'users:update');
        if ($permission) { return $permission; }

        // Try to get the user, else gives a 404 back instead of a 500 error.
        $user = User::where('id', $userId)->firstOrFail();

        $twoFactorEnabled = $request->input('two_factor_enabled') ?? null;
        $suspended = $request->input('suspended')? Carbon::now() : null;
        $user->suspended_at = $suspended;

        if ($twoFactorEnabled != ($user->two_factor_confirmed_at ? true : false)) {
            if (!$twoFactorEnabled) {
                $user->two_factor_secret = null;
                $user->two_factor_recovery_codes = null;
                $user->two_factor_confirmed_at = null;
                $user->save();
            }
        }

        $input = $request->all();

        $request->input();
        $user->fill($input)->save();

        return redirect()->route('users.index')->banner('Mederwerker is successvol aangepast!');
    }

    public function delete(Request $request, $userId)
    {
        $permission = Role::checkPermission($request->user(), 'users:delete');
        if ($permission) { return $permission; }

        // Try to get the user, else gives a 404 back instead of a 500 error.
        $user = User::where('id', $userId)->firstOrFail();
        $user->delete();

        return redirect()->route('users.index')->banner('Mederwerker is successvol verwijdered!');
    }

    public function suspend(Request $request, $userId){
        $permission = Role::checkPermission($request->user(), 'users:update');
        if ($permission) { return $permission; }

        // Try to get the user, else gives a 404 back instead of a 500 error.
        $user = User::where('id', $userId)->firstOrFail();

        if ($request->get('suspended')){
            $user->suspended_at = null;
            $request->session()->flash('flash.banner', 'Gebruiker succesvol gedeblokkeerd.');
        } else {
            $user->suspended_at = Carbon::now();
            $request->session()->flash('flash.banner', 'Gebruiker succesvol geblokkeerd.');
        }
        $user->save();
    }
}
