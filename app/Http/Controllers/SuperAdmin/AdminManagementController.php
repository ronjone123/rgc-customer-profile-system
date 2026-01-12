<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Enums\BranchStatus;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


class AdminManagementController extends Controller
{
    public function index()
    {
        $admins = User::whereIn('role', [
            User::ROLE_HEAD_ADMIN,
            User::ROLE_BRANCH_ADMIN,
        ])->get();

        return view('superadmin.admins.index', compact('admins'));
    }

    public function create()
    {
        $branches = Branch::where('status', BranchStatus::ACTIVE)
            ->orderBy('name')
            ->get();

        return view('superadmin.admins.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed'],

            'role' => [
                'required',
                Rule::in([User::ROLE_HEAD_ADMIN, User::ROLE_BRANCH_ADMIN]),
            ],

            // ✅ Active branches only + role rules enforced below
            'branch_id' => [
                'nullable',
                Rule::exists('branches', 'id')->where(fn ($q) =>
                    $q->where('status', BranchStatus::ACTIVE)
                ),
            ],
        ], [
            'branch_id.exists' => 'Selected branch is not available (archived or invalid).',
        ]);

        // ✅ Role ↔ branch rules
        if ($validated['role'] === User::ROLE_BRANCH_ADMIN && empty($validated['branch_id'])) {
            return back()->withErrors(['branch_id' => 'Branch is required for Branch Admin.'])->withInput();
        }

        if ($validated['role'] === User::ROLE_HEAD_ADMIN) {
            $validated['branch_id'] = null;
        }

        User::create([
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'password'  => Hash::make($validated['password']),
            'role'      => $validated['role'],
            'branch_id' => $validated['role'] === User::ROLE_BRANCH_ADMIN ? $validated['branch_id'] : null,
            'status'    => 'active',
        ]);

        return redirect()
            ->route('superadmin.admins.index')
            ->with('success', 'Admin created successfully.');
    }

    public function edit(User $admin)
{
    if ($admin->id === auth()->id()) {
        abort(403, 'You cannot edit your own account.');
    }

    if ($admin->role === User::ROLE_SUPERADMIN) {
        abort(403, 'You cannot edit a superadmin.');
    }

    $branches = Branch::where('status', BranchStatus::ACTIVE)
        ->orderBy('name')
        ->get();

    if ($admin->branch_id && !$branches->contains('id', $admin->branch_id)) {
        if ($current = Branch::find($admin->branch_id)) {
            $branches->push($current);
        }
    }

    $branches = $branches->sortBy('name')->values();

    return view('superadmin.admins.edit', compact('admin', 'branches'));
}



    public function update(Request $request, User $admin)
    {
        if ($admin->id === auth()->id()) {
            abort(403, 'You cannot edit your own account.');
        }

        if ($admin->role === User::ROLE_SUPERADMIN) {
            abort(403, 'You cannot edit a superadmin.');
        }

        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($admin->id),
            ],

            'role' => [
                'required',
                Rule::in([User::ROLE_HEAD_ADMIN, User::ROLE_BRANCH_ADMIN]),
            ],

            // ✅ Active branches only (strict policy)
            'branch_id' => [
                'nullable',
                function ($attr, $value, $fail) use ($request, $admin) {
                    // Branch Admin must have a branch
                    if ($request->role === User::ROLE_BRANCH_ADMIN && empty($value)) {
                        $fail('Branch is required for Branch Admin.');
                        return;
                    }

                    // If not Branch Admin, we don't validate branch here (it will be nulled later)
                    if ($request->role !== User::ROLE_BRANCH_ADMIN) {
                        return;
                    }

                    // Allow keeping the same branch_id even if archived
                    if ((int) $value === (int) $admin->branch_id) {
                        return;
                    }

                    // Otherwise, only allow switching to ACTIVE branches
                    $ok = Branch::where('id', $value)
                        ->where('status', BranchStatus::ACTIVE)
                        ->exists();

                    if (! $ok) {
                        $fail('The selected branch is archived and cannot receive new assignments.');
                    }
                },
            ],

            'password' => ['nullable', 'min:8', 'confirmed'],
        ], [
            'branch_id.exists' => 'Selected branch is not available (archived or invalid).',
        ]);

        // ✅ Role ↔ branch rules
        if ($validated['role'] === User::ROLE_HEAD_ADMIN) {
            $validated['branch_id'] = null;
        }

        // Password handling
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $admin->update($validated);

        return redirect()
            ->route('superadmin.admins.index')
            ->with('success', 'Admin updated successfully.');
    }

    public function destroy(User $admin)
    {
        if ($admin->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        if ($admin->role === User::ROLE_HEAD_ADMIN) {
            return back()->with('error', 'Head Admin accounts cannot be deleted.');
        }

        if ($admin->role === User::ROLE_SUPERADMIN) {
            return back()->with('error', 'Superadmin accounts cannot be deleted.');
        }

        $admin->delete();

        return back()->with('success', 'Admin deleted successfully.');
    }

    public function suspend($id)
    {
        $admin = User::findOrFail($id);

        if ($admin->id === auth()->id()) {
            return back()->with('error', 'You cannot suspend your own account.');
        }

        if ($admin->role === User::ROLE_SUPERADMIN) {
            return back()->with('error', 'You cannot suspend a superadmin.');
        }

        // ✅ Prevent suspending last active head admin
        if ($admin->role === User::ROLE_HEAD_ADMIN && $admin->status === 'active') {
            $activeHeadAdmins = User::where('role', User::ROLE_HEAD_ADMIN)
                ->where('status', 'active')
                ->count();

            if ($activeHeadAdmins <= 1) {
                return back()->with('error', 'At least one active Head Admin is required.');
            }
        }

        $admin->update(['status' => 'suspended']);

        return back()->with('success', 'Admin suspended.');
    }

    public function activate($id)
    {
        $admin = User::findOrFail($id);

        if ($admin->role === User::ROLE_SUPERADMIN) {
            return back()->with('error', 'You cannot activate a superadmin.');
        }

        $admin->update(['status' => 'active']);

        return back()->with('success', 'Admin activated.');
    }
}
