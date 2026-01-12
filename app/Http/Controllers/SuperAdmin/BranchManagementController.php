<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Enums\BranchStatus;
use Illuminate\Support\Facades\Auth;

class BranchManagementController extends Controller
{
    public function index(Request $request)
{
    $show = $request->query('show', 'active'); // active | archived | deleted

    // Base query depends on tab
    $query = $show === 'deleted'
        ? Branch::onlyTrashed()
        : Branch::query();

    $query->withCount('users')
        ->withCount([
            'users as total_admins' => fn ($q) =>
                $q->whereIn('role', ['head_admin', 'branch_admin']),
            'users as active_admins' => fn ($q) =>
                $q->whereIn('role', ['head_admin', 'branch_admin'])->where('status', BranchStatus::ACTIVE),
            'users as suspended_admins' => fn ($q) =>
                $q->whereIn('role', ['head_admin', 'branch_admin'])->where('status', 'suspended'),
        ]);

    // Apply lifecycle filter only for non-deleted tabs
    if ($show === 'archived') {
        $query->where('status', BranchStatus::ARCHIVED);
    } elseif ($show === 'active') {
        $query->where('status', BranchStatus::ACTIVE);
    }

    // Ordering
    if ($show === 'deleted') {
        $query->orderByDesc('deleted_at');
    } else {
        $query->orderBy('name');
    }

    $branches = $query->get();

    return view('superadmin.branches.index', compact('branches', 'show'));
}



    public function create()
    {
        return view('superadmin.branches.create');
    }

    public function store(Request $request)
    {
    $validated = $request->validate(
        [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('branches', 'name'),
            ],
        ],
        [
            'name.unique' => 'This branch already exists.',
        ]
    );

    Branch::create([
        'name' => $validated['name'],
    ]);

    return redirect()
        ->route('superadmin.branches.index')
        ->with('success', 'Branch created successfully.');
    }
    
    public function edit(Branch $branch)
{
    if ($branch->status === BranchStatus::ARCHIVED) {
        return redirect()
            ->route('superadmin.branches.index')
            ->with('error', 'Archived branches cannot be edited. Restore the branch first.');
    }

    return view('superadmin.branches.edit', compact('branch'));
}

    public function update(Request $request, Branch $branch)
{
    if ($branch->status === BranchStatus::ARCHIVED) {
        return redirect()
            ->route('superadmin.branches.index')
            ->with('error', 'Archived branches cannot be updated. Restore the branch first.');
    }

    $validated = $request->validate(
        [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('branches', 'name')->ignore($branch->id),
            ],
        ],
        [
            'name.unique' => 'This branch already exists.',
        ]
    );

    $branch->update([
        'name' => $validated['name'],
    ]);

    return redirect()
        ->route('superadmin.branches.index')
        ->with('success', 'Branch updated successfully.');
}

   public function destroy(Branch $branch)
{
    // Rule A: protect Main Branch
    if (strtolower(trim($branch->name)) === 'main branch') {
        return back()->with('error', 'Main Branch cannot be deleted.');
    }

    // Rule B: prevent deleting last remaining branch
    if (Branch::count() <= 1) {
        return back()->with('error', 'You cannot delete the last remaining branch.');
    }

    // Rule C: cannot delete if any users are assigned
    $assignedUsersCount = $branch->users()->count();

    if ($assignedUsersCount > 0) {
        return back()->with(
            'error',
            "Cannot delete this branch. {$assignedUsersCount} user(s) are still assigned. Reassign them first."
        );
    }

    // Rule D: prevent deleting the last ACTIVE branch
    if ($branch->status === BranchStatus::ACTIVE) {
    $activeCount = Branch::where('status', BranchStatus::ACTIVE)->count();
    if ($activeCount <= 1) {
        return back()->with('error', 'Cannot delete the last active branch.');
    }
}

    $branch->delete();

    return back()->with('success', 'Branch deleted successfully.');
}
public function undelete($id)
{
    $branch = Branch::withTrashed()->findOrFail($id);

    // Optional: prevent restoring a branch whose name conflicts with an existing active one
    // (Usually not needed unless you allow renames + reuse)
    $branch->restore();

    return back()->with('success', 'Branch restored from deleted state.');
}

public function forceDelete($id)
{
    $branch = Branch::withTrashed()->findOrFail($id);

    // EXTREME RESTRICTIONS ONLY:
    if (strtolower(trim($branch->name)) === 'main branch') {
        return back()->with('error', 'Main Branch cannot be permanently deleted.');
    }

    if ($branch->users()->withTrashed()->exists()) {
        return back()->with('error', 'Cannot permanently delete. Users are still assigned.');
    }

    $branch->forceDelete();

    return back()->with('success', 'Branch permanently deleted.');
}


    public function archive(Branch $branch)
{
    if (strtolower(trim($branch->name)) === 'main branch') {
        return back()->with('error', 'Main Branch cannot be archived.');
    }

    if ($branch->status === BranchStatus::ARCHIVED) {
        return back()->with('success', 'Branch is already archived.');
    }

    $activeCount = Branch::where('status', BranchStatus::ACTIVE)->count();
    if ($activeCount <= 1) {
        return back()->with('error', 'Cannot archive the last active branch.');
    }

    $branch->update([
        'status'      => BranchStatus::ARCHIVED,
        'archived_at' => now(),
        'archived_by' => Auth::id(),
    ]);

    return back()->with('success', 'Branch archived successfully.');
}


    public function restore(Branch $branch)
{
    if ($branch->status === BranchStatus::ACTIVE) {
        return back()->with('success', 'Branch is already active.');
    }

    $branch->update([
        'status'      => BranchStatus::ACTIVE,
        'archived_at' => null,
        'archived_by' => null,
    ]);

    return back()->with('success', 'Branch restored successfully.');
}




}
