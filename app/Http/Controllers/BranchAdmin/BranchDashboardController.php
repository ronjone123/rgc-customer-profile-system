<?php

namespace App\Http\Controllers\BranchAdmin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\User;

class BranchDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if (! $user->branch_id) {
            abort(403, 'Branch admin is not assigned to a branch.');
        }

        $branch = Branch::withTrashed()
        ->withCount([
         'users as branch_admins_count' => fn ($q) =>
            $q->where('role', User::ROLE_BRANCH_ADMIN),
            'users as users_count' => fn ($q) =>
            $q->where('role', User::ROLE_USER), // or 'user' if you don't have constant yet
            ])
        ->findOrFail($user->branch_id);

        if ($branch->trashed()) {
            abort(403, 'Your branch is deleted. Contact a superadmin.');
        }

        if ($branch->isArchived()) {
            abort(403, 'Your branch is archived. Contact a superadmin.');
        }


        return view('branch.dashboard', compact('branch'));
    }
}
