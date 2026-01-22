<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-dark-800 leading-tight">
            Create Customer
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <x-flash />

                <form method="POST" action="{{ route('user.customers.store') }}" class="space-y-8">
                    @csrf

                    {{-- CUSTOMER INFO --}}
                    <div class="border rounded-lg p-4">
                        <h3 class="font-semibold text-lg mb-4">Customer Info</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="full_name" value="Customer Full Name *" />
                                <x-text-input id="full_name" name="full_name" type="text" class="mt-1 block w-full"
                                    value="{{ old('full_name') }}" required />
                                <x-input-error :messages="$errors->get('full_name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="spouse_full_name" value="Spouse Full Name" />
                                <x-text-input id="spouse_full_name" name="spouse_full_name" type="text" class="mt-1 block w-full"
                                    value="{{ old('spouse_full_name') }}" />
                                <x-input-error :messages="$errors->get('spouse_full_name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="birthday" value="Birthday" />
                                <x-text-input id="birthday" name="birthday" type="date" class="mt-1 block w-full"
                                    value="{{ old('birthday') }}" />
                                <x-input-error :messages="$errors->get('birthday')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="maker_status" value="Maker Status" />
                                <x-text-input id="maker_status" name="maker_status" type="text" class="mt-1 block w-full"
                                    value="{{ old('maker_status') }}" />
                                <x-input-error :messages="$errors->get('maker_status')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="maker_contact" value="Maker Contact # (Customer) *" />
                                <x-text-input id="maker_contact" name="maker_contact" type="text" class="mt-1 block w-full"
                                    value="{{ old('maker_contact') }}" required />
                                <x-input-error :messages="$errors->get('maker_contact')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="address_line" value="Address (#, St., Prk) *" />
                                <x-text-input id="address_line" name="address_line" type="text" class="mt-1 block w-full"
                                    value="{{ old('address_line') }}" required />
                                <x-input-error :messages="$errors->get('address_line')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="address_barangay" value="Address (Brgy) *" />
                                <x-text-input id="address_barangay" name="address_barangay" type="text" class="mt-1 block w-full"
                                    value="{{ old('address_barangay') }}" required />
                                <x-input-error :messages="$errors->get('address_barangay')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="address_city_province" value="Address (Town/City, Prov) *" />
                                <x-text-input id="address_city_province" name="address_city_province" type="text" class="mt-1 block w-full"
                                    value="{{ old('address_city_province') }}" required />
                                <x-input-error :messages="$errors->get('address_city_province')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="provincial_address" value="Provincial Address" />
                                <x-text-input id="provincial_address" name="provincial_address" type="text" class="mt-1 block w-full"
                                    value="{{ old('provincial_address') }}" />
                                <x-input-error :messages="$errors->get('provincial_address')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    {{-- CUSTOMER VALID ID --}}
                    <div class="border rounded-lg p-4">
                        <h3 class="font-semibold text-lg mb-4">Customer Valid ID Details</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="cust_id_type" value="Type of ID *" />
                                <x-text-input id="cust_id_type" name="cust_id_type" type="text" class="mt-1 block w-full"
                                    value="{{ old('cust_id_type') }}" required />
                                <x-input-error :messages="$errors->get('cust_id_type')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="cust_id_number" value="ID # *" />
                                <x-text-input id="cust_id_number" name="cust_id_number" type="text" class="mt-1 block w-full"
                                    value="{{ old('cust_id_number') }}" required />
                                <x-input-error :messages="$errors->get('cust_id_number')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="cust_ctc_no" value="CTC No. *" />
                                <x-text-input id="cust_ctc_no" name="cust_ctc_no" type="text" class="mt-1 block w-full"
                                    value="{{ old('cust_ctc_no') }}" required />
                                <x-input-error :messages="$errors->get('cust_ctc_no')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="cust_place_of_issue" value="Place of Issue *" />
                                <x-text-input id="cust_place_of_issue" name="cust_place_of_issue" type="text" class="mt-1 block w-full"
                                    value="{{ old('cust_place_of_issue') }}" required />
                                <x-input-error :messages="$errors->get('cust_place_of_issue')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    {{-- CO-MAKER INFO --}}
                    <div class="border rounded-lg p-4">
                        <h3 class="font-semibold text-lg mb-4">Co-maker Info (Required)</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="co_name" value="Co-maker Name *" />
                                <x-text-input id="co_name" name="co_name" type="text" class="mt-1 block w-full"
                                    value="{{ old('co_name') }}" required />
                                <x-input-error :messages="$errors->get('co_name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="co_address_line" value="Co-maker Address (#, St., Prk, Brgy) *" />
                                <x-text-input id="co_address_line" name="co_address_line" type="text" class="mt-1 block w-full"
                                    value="{{ old('co_address_line') }}" required />
                                <x-input-error :messages="$errors->get('co_address_line')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="co_address_city_province" value="Co-maker Address (Town/City, Prov) *" />
                                <x-text-input id="co_address_city_province" name="co_address_city_province" type="text" class="mt-1 block w-full"
                                    value="{{ old('co_address_city_province') }}" required />
                                <x-input-error :messages="$errors->get('co_address_city_province')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-6">
                            <h4 class="font-semibold mb-3">Co-maker Valid ID Details (Required)</h4>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="co_id_type" value="Type of ID *" />
                                    <x-text-input id="co_id_type" name="co_id_type" type="text" class="mt-1 block w-full"
                                        value="{{ old('co_id_type') }}" required />
                                    <x-input-error :messages="$errors->get('co_id_type')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="co_id_number" value="ID # *" />
                                    <x-text-input id="co_id_number" name="co_id_number" type="text" class="mt-1 block w-full"
                                        value="{{ old('co_id_number') }}" required />
                                    <x-input-error :messages="$errors->get('co_id_number')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="co_ctc_no" value="CTC No. *" />
                                    <x-text-input id="co_ctc_no" name="co_ctc_no" type="text" class="mt-1 block w-full"
                                        value="{{ old('co_ctc_no') }}" required />
                                    <x-input-error :messages="$errors->get('co_ctc_no')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="co_place_of_issue" value="Place of Issue *" />
                                    <x-text-input id="co_place_of_issue" name="co_place_of_issue" type="text" class="mt-1 block w-full"
                                        value="{{ old('co_place_of_issue') }}" required />
                                    <x-input-error :messages="$errors->get('co_place_of_issue')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- SALES SOURCE --}}
                    <div class="border rounded-lg p-4">
                        <h3 class="font-semibold text-lg mb-4">Sales Source</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="sales_type" value="Sales Type" />
                                <x-text-input id="sales_type" name="sales_type" type="text" class="mt-1 block w-full"
                                    value="{{ old('sales_type') }}" />
                                <x-input-error :messages="$errors->get('sales_type')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="referred_by" value="Referred By" />
                                <x-text-input id="referred_by" name="referred_by" type="text" class="mt-1 block w-full"
                                    value="{{ old('referred_by') }}" />
                                <x-input-error :messages="$errors->get('referred_by')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    {{-- TRANSACTION INFO --}}
                    <div class="border rounded-lg p-4">
                        <h3 class="font-semibold text-lg mb-4">Transaction Info (Required)</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="txn_date" value="Date *" />
                                <x-text-input id="txn_date" name="txn_date" type="date" class="mt-1 block w-full"
                                    value="{{ old('txn_date') }}" required />
                                <x-input-error :messages="$errors->get('txn_date')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="txn_account_number" value="Account Number *" />
                                <x-text-input id="txn_account_number" name="txn_account_number" type="text" class="mt-1 block w-full"
                                    value="{{ old('txn_account_number') }}" required />
                                <x-input-error :messages="$errors->get('txn_account_number')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="nrp_number" value="NRP Number *" />
                                <x-text-input id="nrp_number" name="nrp_number" type="text" class="mt-1 block w-full"
                                    value="{{ old('nrp_number') }}" required />
                                <x-input-error :messages="$errors->get('nrp_number')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="si_number" value="SI Number *" />
                                <x-text-input id="si_number" name="si_number" type="text" class="mt-1 block w-full"
                                    value="{{ old('si_number') }}" required />
                                <x-input-error :messages="$errors->get('si_number')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="dr_number" value="DR Number *" />
                                <x-text-input id="dr_number" name="dr_number" type="text" class="mt-1 block w-full"
                                    value="{{ old('dr_number') }}" required />
                                <x-input-error :messages="$errors->get('dr_number')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="area_type_number" value="Area (Type Number) *" />
                                <x-text-input id="area_type_number" name="area_type_number" type="text" class="mt-1 block w-full"
                                    value="{{ old('area_type_number') }}" required />
                                <x-input-error :messages="$errors->get('area_type_number')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="area_location" value="Area (Location) *" />
                                <x-text-input id="area_location" name="area_location" type="text" class="mt-1 block w-full"
                                    value="{{ old('area_location') }}" required />
                                <x-input-error :messages="$errors->get('area_location')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="mc_make" value="MC Make *" />
                                <x-text-input id="mc_make" name="mc_make" type="text" class="mt-1 block w-full"
                                    value="{{ old('mc_make') }}" required />
                                <x-input-error :messages="$errors->get('mc_make')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="mc_model" value="MC Model *" />
                                <x-text-input id="mc_model" name="mc_model" type="text" class="mt-1 block w-full"
                                    value="{{ old('mc_model') }}" required />
                                <x-input-error :messages="$errors->get('mc_model')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="engine_number" value="Engine Number / Serial *" />
                                <x-text-input id="engine_number" name="engine_number" type="text" class="mt-1 block w-full"
                                    value="{{ old('engine_number') }}" required />
                                <x-input-error :messages="$errors->get('engine_number')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="chassis_number" value="Chassis Number *" />
                                <x-text-input id="chassis_number" name="chassis_number" type="text" class="mt-1 block w-full"
                                    value="{{ old('chassis_number') }}" required />
                                <x-input-error :messages="$errors->get('chassis_number')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="color" value="Color *" />
                                <x-text-input id="color" name="color" type="text" class="mt-1 block w-full"
                                    value="{{ old('color') }}" required />
                                <x-input-error :messages="$errors->get('color')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="mc_classification" value="MC Classification *" />
                                <x-text-input id="mc_classification" name="mc_classification" type="text" class="mt-1 block w-full"
                                    value="{{ old('mc_classification') }}" required />
                                <x-input-error :messages="$errors->get('mc_classification')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="mc_body_type" value="MC Body Type *" />
                                <x-text-input id="mc_body_type" name="mc_body_type" type="text" class="mt-1 block w-full"
                                    value="{{ old('mc_body_type') }}" required />
                                <x-input-error :messages="$errors->get('mc_body_type')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="engine_displacement_cc" value="Engine Displacement (CC) *" />
                                <x-text-input id="engine_displacement_cc" name="engine_displacement_cc" type="number" class="mt-1 block w-full"
                                    value="{{ old('engine_displacement_cc') }}" required />
                                <x-input-error :messages="$errors->get('engine_displacement_cc')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    {{-- FINANCIAL INFO --}}
                    <div class="border rounded-lg p-4">
                        <h3 class="font-semibold text-lg mb-4">Financial Info (Required)</h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <x-input-label for="cod" value="COD *" />
                                <x-text-input id="cod" name="cod" type="number" step="0.01" class="mt-1 block w-full"
                                    value="{{ old('cod') }}" required />
                                <x-input-error :messages="$errors->get('cod')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="downpayment" value="Downpayment *" />
                                <x-text-input id="downpayment" name="downpayment" type="number" step="0.01" class="mt-1 block w-full"
                                    value="{{ old('downpayment') }}" required />
                                <x-input-error :messages="$errors->get('downpayment')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="term" value="Term (months) *" />
                                <x-text-input id="term" name="term" type="number" class="mt-1 block w-full"
                                    value="{{ old('term') }}" required />
                                <x-input-error :messages="$errors->get('term')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="monthly_amortization" value="Monthly Amortization *" />
                                <x-text-input id="monthly_amortization" name="monthly_amortization" type="number" step="0.01" class="mt-1 block w-full"
                                    value="{{ old('monthly_amortization') }}" required />
                                <x-input-error :messages="$errors->get('monthly_amortization')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="rebate" value="Rebate *" />
                                <x-text-input id="rebate" name="rebate" type="number" step="0.01" class="mt-1 block w-full"
                                    value="{{ old('rebate') }}" required />
                                <x-input-error :messages="$errors->get('rebate')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="pn_value" value="PN Value *" />
                                <x-text-input id="pn_value" name="pn_value" type="number" step="0.01" class="mt-1 block w-full"
                                    value="{{ old('pn_value') }}" required />
                                <x-input-error :messages="$errors->get('pn_value')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="tip" value="TIP *" />
                                <x-text-input id="tip" name="tip" type="number" step="0.01" class="mt-1 block w-full"
                                    value="{{ old('tip') }}" required />
                                <x-input-error :messages="$errors->get('tip')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="amount_financed" value="Amount Financed (AF) *" />
                                <x-text-input id="amount_financed" name="amount_financed" type="number" step="0.01" class="mt-1 block w-full"
                                    value="{{ old('amount_financed') }}" required />
                                <x-input-error :messages="$errors->get('amount_financed')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="finance_charges" value="Finance Charges *" />
                                <x-text-input id="finance_charges" name="finance_charges" type="number" step="0.01" class="mt-1 block w-full"
                                    value="{{ old('finance_charges') }}" required />
                                <x-input-error :messages="$errors->get('finance_charges')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="aoc" value="AOC *" />
                                <x-text-input id="aoc" name="aoc" type="number" step="0.01" class="mt-1 block w-full"
                                    value="{{ old('aoc') }}" required />
                                <x-input-error :messages="$errors->get('aoc')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="first_due_date" value="First Due Date *" />
                                <x-text-input id="first_due_date" name="first_due_date" type="date" class="mt-1 block w-full"
                                    value="{{ old('first_due_date') }}" required />
                                <x-input-error :messages="$errors->get('first_due_date')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="maturity_date" value="Maturity Date *" />
                                <x-text-input id="maturity_date" name="maturity_date" type="date" class="mt-1 block w-full"
                                    value="{{ old('maturity_date') }}" required />
                                <x-input-error :messages="$errors->get('maturity_date')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="downpayment_cr_no" value="Downpayment CR No. *" />
                                <x-text-input id="downpayment_cr_no" name="downpayment_cr_no" type="text" class="mt-1 block w-full"
                                    value="{{ old('downpayment_cr_no') }}" required />
                                <x-input-error :messages="$errors->get('downpayment_cr_no')" class="mt-2" />
                            </div>

                            <div class="md:col-span-3">
                                <x-input-label for="fin_account_number" value="Account Number (Financial) *" />
                                <x-text-input id="fin_account_number" name="fin_account_number" type="text" class="mt-1 block w-full"
                                    value="{{ old('fin_account_number') }}" required />
                                <x-input-error :messages="$errors->get('fin_account_number')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <x-primary-button>
                            Save Customer
                        </x-primary-button>

                        <a href="{{ route('user.customers.index') }}" class="text-sm text-gray-600 hover:underline">
                            Cancel
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
