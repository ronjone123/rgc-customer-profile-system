<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Services\Customer\CreateCustomerService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::query()
            ->where('branch_id', auth()->user()->branch_id)
            ->with('creator')
            ->latest()
            ->paginate(15);

        return view('user.customers.index', compact('customers'));
    }

    public function create()
    {
        return view('user.customers.create');
    }

    public function store(Request $request, CreateCustomerService $service)
    {
        $validated = $this->validateRequest($request);

        try {
            $service->execute($validated, auth()->user());

            return redirect()
                ->route('user.customers.index')
                ->with('success', 'Customer created successfully.');
        } catch (\Throwable $e) {
            report($e);

            return back()
                ->withErrors('Failed to create customer. Please try again.')
                ->withInput();
        }
    }
    public function show(Customer $customer)
    {
        // Security: ensure same branch
        abort_if(
            $customer->branch_id !== auth()->user()->branch_id,
            403
        );

        $customer->load([
            'creator',
            'idDetail',
            'coMaker',
            'transaction',
            'financial',
            'audits',
        ]);

        return view('user.customers.show', compact('customer'));
    }


    private function validateRequest(Request $request): array
    {
        return $request->validate([
            // Customer
            'full_name' => 'required|string|max:255',
            'spouse_full_name' => 'nullable|string|max:255',
            'birthday' => 'nullable|date',
            'maker_status' => 'nullable|string|max:50',
            'maker_contact' => 'nullable|string|max:50',

            // Address
            'address_line' => 'nullable|string|max:255',
            'address_barangay' => 'nullable|string|max:255',
            'address_city_province' => 'nullable|string|max:255',
            'provincial_address' => 'nullable|string|max:255',

            // Customer ID
            'cust_id_type' => 'required|string|max:100',
            'cust_id_number' => 'required|string|max:100',
            'cust_ctc_no' => 'nullable|string|max:100',
            'cust_place_of_issue' => 'nullable|string|max:255',

            // Co-maker
            'co_name' => 'required|string|max:255',
            'co_address_line' => 'required|string|max:255',
            'co_address_city_province' => 'required|string|max:255',
            'co_id_type' => 'nullable|string|max:100',
            'co_id_number' => 'nullable|string|max:100',
            'co_ctc_no' => 'nullable|string|max:100',
            'co_place_of_issue' => 'nullable|string|max:255',

            // Transaction
            'txn_date' => 'required|date',
            'txn_account_number' => 'required|string|max:100',
            'nrp_number' => 'nullable|string|max:100',
            'si_number' => 'nullable|string|max:100',
            'dr_number' => 'nullable|string|max:100',
            'area_type_number' => 'nullable|string|max:100',
            'area_location' => 'nullable|string|max:255',

            // Motorcycle
            'mc_make' => 'nullable|string|max:100',
            'mc_model' => 'nullable|string|max:100',
            'engine_number' => 'nullable|string|max:100',
            'chassis_number' => 'nullable|string|max:100',
            'color' => 'nullable|string|max:50',
            'mc_classification' => 'nullable|string|max:100',
            'mc_body_type' => 'nullable|string|max:100',
            'engine_displacement_cc' => 'nullable|numeric',

            // Financial
            'cod' => 'nullable|numeric',
            'downpayment' => 'required|numeric',
            'term' => 'required|integer|min:1',
            'monthly_amortization' => 'required|numeric',
            'rebate' => 'nullable|numeric',
            'pn_value' => 'nullable|numeric',
            'tip' => 'nullable|numeric',
            'amount_financed' => 'nullable|numeric',
            'finance_charges' => 'nullable|numeric',
            'aoc' => 'nullable|numeric',
            'first_due_date' => 'nullable|date',
            'maturity_date' => 'nullable|date',
            'downpayment_cr_no' => 'nullable|string|max:100',
            'fin_account_number' => 'nullable|string|max:100',
        ]);
    }
}
