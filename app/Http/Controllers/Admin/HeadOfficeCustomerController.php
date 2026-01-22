<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerAudit;

class HeadOfficeCustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::query()
            ->with(['branch', 'creator'])
            ->latest()
            ->paginate(20);

        return view('admin.customers.index', compact('customers'));
    }

    public function audits()
    {
        $audits = CustomerAudit::query()
            ->with(['branch', 'actor', 'customer'])
            ->latest()
            ->paginate(30);

        return view('admin.audits.index', compact('audits'));
    }
}
