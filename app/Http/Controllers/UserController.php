<?php

namespace App\Http\Controllers;

use App\Classes\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $permission = Role::checkPermission($request->user(), 'users:read');
        if ($permission) { return $permission; }

        $users = User::paginate();

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

    public function view(Request $request, int $userId)
    {
        $permission = Role::checkPermission($request->user(), 'users:read');
        if ($permission) { return $permission; }

        $user = User::with('role')->find($userId);

        return Inertia::render('Users/View', [
            'user' => $user,
            'two_factor_enabled' => $user->two_factor_confirmed_at ? true : false,
        ]);
    }

    public function create(Request $request)
    {
        $permission = Role::checkPermission($request->user(), 'users:create');
        if ($permission) { return $permission; }

        $firstName = $request->input('first_name');
        $lastName = $request->input('last_name');
        $email = $request->input('email');
        $password = $request->input('password');

        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'password' => 'required|string|max:100',
        ]);

        User::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'password' => bcrypt($password),
        ]);

        return redirect()->route('users.index')->banner("{$firstName} is successvol toegevoeged als medewerker!");
    }

    public function update(Request $request, int $userId)
    {
        $permission = Role::checkPermission($request->user(), 'users:update');
        if ($permission) { return $permission; }

        $user = User::find($userId);
        $newUser = $request->input('user') ?? null;
        $twoFactorEnabled = $request->input('two_factor_enabled') ?? null;

        $request->validate([
            'user' => 'required',
        ]);

        if ($newUser) {
            $user->update($newUser);
        }

        if ($twoFactorEnabled != ($user->two_factor_confirmed_at ? true : false)) {
            if (!$twoFactorEnabled) {
                $user->two_factor_secret = null;
                $user->two_factor_recovery_codes = null;
                $user->two_factor_confirmed_at = null;
                $user->save();
            }
        }

        return redirect()->route('users.index')->banner('Mederwerker is successvol aangepast!');
    }

    public function delete(Request $request, int $userId)
    {
        $permission = Role::checkPermission($request->user(), 'users:delete');
        if ($permission) { return $permission; }

        $user = User::find($userId);
        $user->delete();

        return redirect()->route('users.index')->banner('Mederwerker is successvol verwijdered!');
    }

    public function suspend($userId){
        $user = User::find($userId);
        $user->suspended_at = Carbon::now();
        $user->save();

        return redirect()->route('users.index')->banner('Mederwerker is successvol geblokkeerd!');
    }

    public function unsuspend($userId){
        $user = User::find($userId);
        $user->suspended_at = null;
        $user->save();

        return redirect()->route('users.index')->banner('Mederwerker is successvol gedeblokkeerd!');
    }
}
