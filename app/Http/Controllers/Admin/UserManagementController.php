<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    // SUPERADMIN: view admins
    public function index()
    {
        $admins = User::where('is_admin', 1)->get();
        return view('superadmin.admins.index', compact('admins'));
    }

    // SUPERADMIN: create admin form
    public function createAdmin()
    {
        return view('superadmin.admins.create');
    }

    // SUPERADMIN: store admin
    public function storeAdmin(Request $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => 1,
            'is_superadmin' => 0,
            'is_user' => 0,
        ]);

        return redirect()->route('superadmin.admins')->with('success', 'Admin created!');
    }

    // ADMIN: list normal staff
    public function listUsers()
    {
        $users = User::where('role', User::ROLE_USER ?? 'user')->get();
        return view('admin.users.index', compact('users'));
    }

    // ADMIN: add staff
    public function createUser()
    {
        return view('admin.users.create');
    }

    // ADMIN: store staff
    public function storeUser(Request $request)
    {
        User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'is_user'    => 1,
        ]);

        return redirect()->route('admin.users')->with('success', 'User created!');
    }
}
