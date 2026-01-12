<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Enums\BranchStatus;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::where('role', User::ROLE_USER ?? 'user')
            ->with('branch')
            ->orderBy('name')
            ->paginate(15);

        return view('superadmin.users.index', compact('users'));
    }

    public function create()
    {
        $branches = Branch::where('status', BranchStatus::ACTIVE)
            ->orderBy('name')
            ->get();

        return view('superadmin.users.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'password'  => ['required', 'min:8', 'confirmed'],
            'branch_id' => [
                'required',
                Rule::exists('branches', 'id')->where(fn ($q) =>
                    $q->where('status', BranchStatus::ACTIVE)
                ),
            ],
        ], [
            'branch_id.exists' => 'Selected branch is archived or invalid.',
        ]);

        User::create([
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'password'  => Hash::make($validated['password']),
            'role'      => User::ROLE_USER ?? 'user',
            'status'    => 'active',
            'branch_id' => $validated['branch_id'],
        ]);

        return redirect()
            ->route('superadmin.users.index')
            ->with('success', 'User created successfully.');
    }
}
