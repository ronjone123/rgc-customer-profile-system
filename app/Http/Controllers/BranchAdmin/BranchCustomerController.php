<?php

namespace App\Http\Controllers\BranchAdmin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerAudit;

class BranchCustomerController extends Controller
{
    private function branchIdOrFail(): int
    {
        $branchId = auth()->user()?->branch_id;

        if (!$branchId) {
            abort(403, 'Branch Admin is not assigned to a branch.');
        }

        return (int) $branchId;
    }

    public function index()
    {
        $branchId = $this->branchIdOrFail();

        $customers = Customer::query()
            ->where('branch_id', $branchId)
            ->with(['creator'])
            ->latest()
            ->paginate(15);

        return view('branch.customers.index', compact('customers'));
    }

    public function audits()
    {
        $branchId = $this->branchIdOrFail();

        $audits = CustomerAudit::query()
            ->where('branch_id', $branchId)
            ->with(['actor', 'customer'])
            ->latest()
            ->paginate(20);

        return view('branch.audits.index', compact('audits'));
    }
    public function show(Customer $customer)
    {
        abort_if($customer->branch_id !== auth()->user()->branch_id, 403);

        $customer->load([
            'creator',
            'idDetail',
            'coMaker',
            'transaction',
            'financial',
            'audits',
        ]);

        return view('branch.customers.show', compact('customer'));
    }

}
