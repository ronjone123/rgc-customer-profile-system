<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountCreationController extends Controller
{
    public function create()
    {
        return view('superadmin.accounts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:6',
            'role'      => 'required|in:head_admin,branch_admin,user',
            'branch_id' => 'nullable|required_if:role,branch_admin,user',
        ]);

        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => $request->role,
            'branch_id' => $request->branch_id,
        ]);

        return redirect()
            ->route('superadmin.dashboard')
            ->with('success', 'Account created successfully');
    }
}
