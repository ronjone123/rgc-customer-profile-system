<?php

namespace App\Services\Customer;

use App\Models\{
    Customer,
    CustomerAudit,
    CustomerIdDetail,
    CustomerCoMaker,
    CustomerTransaction,
    CustomerFinancial
};
use App\Enums\CustomerStatus;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class CreateCustomerService
{
    public function execute(array $data, User $user): Customer
    {
        return DB::transaction(function () use ($data, $user) {

            $customer = $this->createCustomer($data, $user);
            $this->createCustomerId($customer, $data);
            $this->createCoMaker($customer, $data);
            $this->createTransaction($customer, $data);
            $this->createFinancial($customer, $data);
            $this->createAudit($customer, $user);

            return $customer;
        });
    }

    protected function createCustomer(array $data, User $user): Customer
    {
        return Customer::create([
            'branch_id'  => $user->branch_id,
            'created_by' => $user->id,
            'full_name'  => $data['full_name'],
            'status'     => CustomerStatus::ACTIVE,
        ]);
    }

    protected function createCustomerId(Customer $customer, array $data): void
    {
        CustomerIdDetail::create([
            'customer_id'    => $customer->id,
            'id_type'        => $data['cust_id_type'],
            'id_number'      => $data['cust_id_number'],
            'ctc_no'         => data_get($data, 'cust_ctc_no'),
            'place_of_issue' => data_get($data, 'cust_place_of_issue'),
        ]);
    }

    protected function createCoMaker(Customer $customer, array $data): void
    {
        CustomerCoMaker::create([
            'customer_id'           => $customer->id,
            'name'                  => $data['co_name'],
            'address_line'          => $data['co_address_line'],
            'address_city_province' => $data['co_address_city_province'],
            'id_type'               => data_get($data, 'co_id_type'),
            'id_number'             => data_get($data, 'co_id_number'),
            'ctc_no'                => data_get($data, 'co_ctc_no'),
            'place_of_issue'        => data_get($data, 'co_place_of_issue'),
        ]);
    }

    protected function createTransaction(Customer $customer, array $data): void
    {
        CustomerTransaction::create([
            'customer_id'            => $customer->id,
            'date'                   => $data['txn_date'],
            'account_number'         => $data['txn_account_number'],
            'nrp_number'             => data_get($data, 'nrp_number'),
            'si_number'              => data_get($data, 'si_number'),
            'dr_number'              => data_get($data, 'dr_number'),
            'area_type_number'       => data_get($data, 'area_type_number'),
            'area_location'          => data_get($data, 'area_location'),
            'mc_make'                => data_get($data, 'mc_make'),
            'mc_model'               => data_get($data, 'mc_model'),
            'engine_number'          => data_get($data, 'engine_number'),
            'chassis_number'         => data_get($data, 'chassis_number'),
            'color'                  => data_get($data, 'color'),
            'mc_classification'      => data_get($data, 'mc_classification'),
            'mc_body_type'           => data_get($data, 'mc_body_type'),
            'engine_displacement_cc' => data_get($data, 'engine_displacement_cc'),
        ]);
    }

    protected function createFinancial(Customer $customer, array $data): void
    {
        CustomerFinancial::create([
            'customer_id'          => $customer->id,
            'cod'                  => data_get($data, 'cod'),
            'downpayment'          => $data['downpayment'],
            'term'                 => $data['term'],
            'monthly_amortization' => $data['monthly_amortization'],
            'rebate'               => data_get($data, 'rebate'),
            'pn_value'             => data_get($data, 'pn_value'),
            'tip'                  => data_get($data, 'tip'),
            'amount_financed'      => data_get($data, 'amount_financed'),
            'finance_charges'      => data_get($data, 'finance_charges'),
            'aoc'                  => data_get($data, 'aoc'),
            'first_due_date'       => data_get($data, 'first_due_date'),
            'maturity_date'        => data_get($data, 'maturity_date'),
            'downpayment_cr_no'    => data_get($data, 'downpayment_cr_no'),
            'account_number'       => data_get($data, 'fin_account_number'),
        ]);
    }

    protected function createAudit(Customer $customer, User $user): void
    {
        CustomerAudit::create([
            'customer_id' => $customer->id,
            'branch_id'   => $customer->branch_id,
            'actor_id'    => $user->id,
            'actor_role'  => $user->role,
            'action'      => 'created',
            'field'       => 'customer',
            'old_value'   => null,
            'new_value'   => $customer->full_name,
        ]);
    }
}
