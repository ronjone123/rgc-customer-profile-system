<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">New Customer Application</h2>

            <a href="{{ route('branch.customers.index') }}"
               class="text-sm text-gray-600 hover:underline">
                ← Back
            </a>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto bg-white p-6 rounded shadow">

        {{-- Errors --}}
        @if ($errors->any())
            <div class="mb-4 p-3 rounded bg-red-100 text-red-800">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('branch.customers.store') }}">
            @csrf

            {{-- =========================
                CUSTOMER INFO
            ========================= --}}
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Customer Information</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Customer Full Name *</label>
                        <input type="text" name="customer_full_name"
                               value="{{ old('customer_full_name') }}"
                               class="w-full border rounded px-3 py-2" required>
                        @error('customer_full_name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Spouse Full Name</label>
                        <input type="text" name="spouse_full_name"
                               value="{{ old('spouse_full_name') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('spouse_full_name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Birthday</label>
                        <input type="date" name="birthday"
                               value="{{ old('birthday') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('birthday') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Maker Status</label>
                        <input type="text" name="maker_status"
                               value="{{ old('maker_status') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('maker_status') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- =========================
                ADDRESS INFO
            ========================= --}}
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Address Information</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Address (#, St., Prk)</label>
                        <input type="text" name="address_street"
                               value="{{ old('address_street') }}"
                               class="w-full border rounded px-3 py-2"
                               placeholder="House # / Street / Purok">
                        @error('address_street') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Barangay</label>
                        <input type="text" name="address_barangay"
                               value="{{ old('address_barangay') }}"
                               class="w-full border rounded px-3 py-2"
                               placeholder="Barangay">
                        @error('address_barangay') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Town/City, Province</label>
                        <input type="text" name="address_city_province"
                               value="{{ old('address_city_province') }}"
                               class="w-full border rounded px-3 py-2"
                               placeholder="Town/City, Province">
                        @error('address_city_province') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Provincial Address</label>
                        <input type="text" name="provincial_address"
                               value="{{ old('provincial_address') }}"
                               class="w-full border rounded px-3 py-2"
                               placeholder="If applicable">
                        @error('provincial_address') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- =========================
                CUSTOMER VALID ID
            ========================= --}}
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Customer Valid ID Details</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Type of ID</label>
                        <input type="text" name="customer_id_type"
                               value="{{ old('customer_id_type') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('customer_id_type') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">ID #</label>
                        <input type="text" name="customer_id_number"
                               value="{{ old('customer_id_number') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('customer_id_number') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">CTC No.</label>
                        <input type="text" name="customer_ctc_number"
                               value="{{ old('customer_ctc_number') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('customer_ctc_number') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Place of Issue</label>
                        <input type="text" name="customer_id_place_issued"
                               value="{{ old('customer_id_place_issued') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('customer_id_place_issued') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Maker Contact #</label>
                        <input type="text" name="maker_contact_number"
                               value="{{ old('maker_contact_number') }}"
                               class="w-full border rounded px-3 py-2"
                               placeholder="09xx...">
                        @error('maker_contact_number') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- =========================
                CO-MAKER INFO
            ========================= --}}
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Co-maker Information</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Co-maker Name</label>
                        <input type="text" name="comaker_name"
                               value="{{ old('comaker_name') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('comaker_name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Co-maker Address (#, St., Prk, Brgy)</label>
                        <input type="text" name="comaker_address_street_barangay"
                               value="{{ old('comaker_address_street_barangay') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('comaker_address_street_barangay') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium">Co-maker Address (Town/City, Prov)</label>
                        <input type="text" name="comaker_address_city_province"
                               value="{{ old('comaker_address_city_province') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('comaker_address_city_province') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- =========================
                CO-MAKER VALID ID
            ========================= --}}
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Co-maker Valid ID Details</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Type of ID</label>
                        <input type="text" name="comaker_id_type"
                               value="{{ old('comaker_id_type') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('comaker_id_type') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">ID #</label>
                        <input type="text" name="comaker_id_number"
                               value="{{ old('comaker_id_number') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('comaker_id_number') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">CTC No.</label>
                        <input type="text" name="comaker_ctc_number"
                               value="{{ old('comaker_ctc_number') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('comaker_ctc_number') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Place of Issue</label>
                        <input type="text" name="comaker_id_place_issued"
                               value="{{ old('comaker_id_place_issued') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('comaker_id_place_issued') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- =========================
                SALES SOURCE
            ========================= --}}
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Sales Source (if applicable)</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Sales Type</label>
                        <input type="text" name="sales_type"
                               value="{{ old('sales_type') }}"
                               class="w-full border rounded px-3 py-2"
                               placeholder="Walk-in / FB / Agent / etc">
                        @error('sales_type') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Referred By</label>
                        <input type="text" name="referred_by"
                               value="{{ old('referred_by') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('referred_by') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- =========================
                TRANSACTION INFO
            ========================= --}}
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Transaction Information</h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Date</label>
                        <input type="date" name="transaction_date"
                               value="{{ old('transaction_date') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('transaction_date') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Account Number</label>
                        <input type="text" name="account_number"
                               value="{{ old('account_number') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('account_number') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">NRP Number</label>
                        <input type="text" name="nrp_number"
                               value="{{ old('nrp_number') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('nrp_number') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">SI Number</label>
                        <input type="text" name="si_number"
                               value="{{ old('si_number') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('si_number') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">DR Number</label>
                        <input type="text" name="dr_number"
                               value="{{ old('dr_number') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('dr_number') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Area (Type Number)</label>
                        <input type="text" name="area_type_number"
                               value="{{ old('area_type_number') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('area_type_number') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-3">
                        <label class="block text-sm font-medium">Area (Location)</label>
                        <input type="text" name="area_location"
                               value="{{ old('area_location') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('area_location') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- =========================
                MOTORCYCLE / UNIT INFO
            ========================= --}}
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Motorcycle / Unit Information</h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium">MC Make</label>
                        <input type="text" name="mc_make"
                               value="{{ old('mc_make') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('mc_make') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">MC Model</label>
                        <input type="text" name="mc_model"
                               value="{{ old('mc_model') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('mc_model') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Color</label>
                        <input type="text" name="color"
                               value="{{ old('color') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('color') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium">Engine Number / Serial</label>
                        <input type="text" name="engine_number"
                               value="{{ old('engine_number') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('engine_number') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Chassis Number</label>
                        <input type="text" name="chassis_number"
                               value="{{ old('chassis_number') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('chassis_number') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">MC Classification</label>
                        <input type="text" name="mc_classification"
                               value="{{ old('mc_classification') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('mc_classification') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">MC Body Type</label>
                        <input type="text" name="mc_body_type"
                               value="{{ old('mc_body_type') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('mc_body_type') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Engine Displacement (CC)</label>
                        <input type="number" step="1" min="0" name="engine_displacement_cc"
                               value="{{ old('engine_displacement_cc') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('engine_displacement_cc') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- =========================
                FINANCIAL INFO
            ========================= --}}
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Financial Information</h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium">COD</label>
                        <input type="number" step="0.01" min="0" name="cod"
                               value="{{ old('cod') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('cod') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Downpayment</label>
                        <input type="number" step="0.01" min="0" name="downpayment"
                               value="{{ old('downpayment') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('downpayment') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Term</label>
                        <input type="text" name="term"
                               value="{{ old('term') }}"
                               class="w-full border rounded px-3 py-2"
                               placeholder="e.g. 12 months">
                        @error('term') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Monthly Amortization</label>
                        <input type="number" step="0.01" min="0" name="monthly_amortization"
                               value="{{ old('monthly_amortization') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('monthly_amortization') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Rebate</label>
                        <input type="number" step="0.01" min="0" name="rebate"
                               value="{{ old('rebate') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('rebate') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">PN Value</label>
                        <input type="number" step="0.01" min="0" name="pn_value"
                               value="{{ old('pn_value') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('pn_value') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">TIP</label>
                        <input type="number" step="0.01" min="0" name="tip"
                               value="{{ old('tip') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('tip') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Amount Financed (AF)</label>
                        <input type="number" step="0.01" min="0" name="amount_financed"
                               value="{{ old('amount_financed') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('amount_financed') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Finance Charges</label>
                        <input type="number" step="0.01" min="0" name="finance_charges"
                               value="{{ old('finance_charges') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('finance_charges') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">AOC</label>
                        <input type="number" step="0.01" min="0" name="aoc"
                               value="{{ old('aoc') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('aoc') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">First Due Date</label>
                        <input type="date" name="first_due_date"
                               value="{{ old('first_due_date') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('first_due_date') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Maturity Date</label>
                        <input type="date" name="maturity_date"
                               value="{{ old('maturity_date') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('maturity_date') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Downpayment CR No.</label>
                        <input type="text" name="downpayment_cr_number"
                               value="{{ old('downpayment_cr_number') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('downpayment_cr_number') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- NOTE: you listed account number twice; we already captured it above in Transaction Info --}}
                </div>
            </div>

            {{-- =========================
                ACTIONS
            ========================= --}}
            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('branch.customers.index') }}"
                   class="px-4 py-2 rounded border text-gray-700 hover:bg-gray-50">
                    Cancel
                </a>

                <button type="submit"
                        class="px-6 py-2 rounded bg-indigo-600 hover:bg-indigo-700 text-white">
                    Save Customer
                </button>
            </div>

        </form>
    </div>
</x-app-layout>
