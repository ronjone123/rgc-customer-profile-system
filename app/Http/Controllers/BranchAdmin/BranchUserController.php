<?php

namespace App\Http\Controllers\BranchAdmin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\User;

class BranchUserController extends Controller
{
    public function index()
    {
        $auth = auth()->user();

        if (! $auth->branch_id) {
            abort(403, 'Branch admin is not assigned to a branch.');
        }

        $branch = Branch::withTrashed()->findOrFail($auth->branch_id);

        if ($branch->trashed()) {
            abort(403, 'Your branch is deleted. Contact a superadmin.');
        }

        if ($branch->isArchived()) {
            abort(403, 'Your branch is archived. Contact a superadmin.');
        }

        $users = User::where('branch_id', $branch->id)
            ->where('role', User::ROLE_USER ?? 'user')
            ->orderBy('name')
            ->paginate(15);

        return view('branch.users.index', compact('branch', 'users'));
    }
}
