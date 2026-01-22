<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Customer: {{ $customer->full_name }}
            </h2>

            <a href="{{ route('user.customers.index') }}"
               class="text-sm text-gray-600 hover:underline">
                ← Back
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Basic --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-4">Customer Info</h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div><span class="text-gray-500">Full Name:</span> <div class="font-medium">{{ $customer->full_name }}</div></div>
                    <div><span class="text-gray-500">Status:</span> <div class="font-medium">{{ $customer->status?->value ?? $customer->status }}</div></div>
                    <div><span class="text-gray-500">Created By:</span> <div class="font-medium">{{ $customer->creator?->name ?? '—' }}</div></div>
                </div>
            </div>

            {{-- ID Detail --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-4">Customer Valid ID</h3>

                @if($customer->idDetail)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div><span class="text-gray-500">ID Type:</span> <div class="font-medium">{{ $customer->idDetail->id_type }}</div></div>
                        <div><span class="text-gray-500">ID Number:</span> <div class="font-medium">{{ $customer->idDetail->id_number }}</div></div>
                        <div><span class="text-gray-500">CTC No:</span> <div class="font-medium">{{ $customer->idDetail->ctc_no ?? '—' }}</div></div>
                        <div><span class="text-gray-500">Place of Issue:</span> <div class="font-medium">{{ $customer->idDetail->place_of_issue ?? '—' }}</div></div>
                    </div>
                @else
                    <p class="text-sm text-gray-500">No ID details found.</p>
                @endif
            </div>

            {{-- Co-maker --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-4">Co-maker</h3>

                @if($customer->coMaker)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div><span class="text-gray-500">Name:</span> <div class="font-medium">{{ $customer->coMaker->name }}</div></div>
                        <div><span class="text-gray-500">Address Line:</span> <div class="font-medium">{{ $customer->coMaker->address_line ?? '—' }}</div></div>
                        <div><span class="text-gray-500">City/Province:</span> <div class="font-medium">{{ $customer->coMaker->address_city_province ?? '—' }}</div></div>
                        <div><span class="text-gray-500">ID Type:</span> <div class="font-medium">{{ $customer->coMaker->id_type ?? '—' }}</div></div>
                        <div><span class="text-gray-500">ID Number:</span> <div class="font-medium">{{ $customer->coMaker->id_number ?? '—' }}</div></div>
                        <div><span class="text-gray-500">CTC No:</span> <div class="font-medium">{{ $customer->coMaker->ctc_no ?? '—' }}</div></div>
                        <div><span class="text-gray-500">Place of Issue:</span> <div class="font-medium">{{ $customer->coMaker->place_of_issue ?? '—' }}</div></div>
                    </div>
                @else
                    <p class="text-sm text-gray-500">No co-maker found.</p>
                @endif
            </div>

            {{-- Transaction --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-4">Transaction</h3>

                @if($customer->transaction)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <div><span class="text-gray-500">Date:</span> <div class="font-medium">{{ $customer->transaction->date ?? '—' }}</div></div>
                        <div><span class="text-gray-500">Account #:</span> <div class="font-medium">{{ $customer->transaction->account_number ?? '—' }}</div></div>
                        <div><span class="text-gray-500">NRP #:</span> <div class="font-medium">{{ $customer->transaction->nrp_number ?? '—' }}</div></div>

                        <div><span class="text-gray-500">SI #:</span> <div class="font-medium">{{ $customer->transaction->si_number ?? '—' }}</div></div>
                        <div><span class="text-gray-500">DR #:</span> <div class="font-medium">{{ $customer->transaction->dr_number ?? '—' }}</div></div>

                        <div><span class="text-gray-500">Area Type #:</span> <div class="font-medium">{{ $customer->transaction->area_type_number ?? '—' }}</div></div>
                        <div class="md:col-span-2"><span class="text-gray-500">Area Location:</span> <div class="font-medium">{{ $customer->transaction->area_location ?? '—' }}</div></div>

                        <div><span class="text-gray-500">MC Make:</span> <div class="font-medium">{{ $customer->transaction->mc_make ?? '—' }}</div></div>
                        <div><span class="text-gray-500">MC Model:</span> <div class="font-medium">{{ $customer->transaction->mc_model ?? '—' }}</div></div>
                        <div><span class="text-gray-500">Engine #:</span> <div class="font-medium">{{ $customer->transaction->engine_number ?? '—' }}</div></div>

                        <div><span class="text-gray-500">Chassis #:</span> <div class="font-medium">{{ $customer->transaction->chassis_number ?? '—' }}</div></div>
                        <div><span class="text-gray-500">Color:</span> <div class="font-medium">{{ $customer->transaction->color ?? '—' }}</div></div>
                        <div><span class="text-gray-500">Displacement (CC):</span> <div class="font-medium">{{ $customer->transaction->engine_displacement_cc ?? '—' }}</div></div>
                    </div>
                @else
                    <p class="text-sm text-gray-500">No transaction found.</p>
                @endif
            </div>

            {{-- Financial --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-4">Financial</h3>

                @if($customer->financial)
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
                        <div><span class="text-gray-500">COD:</span> <div class="font-medium">{{ $customer->financial->cod ?? '—' }}</div></div>
                        <div><span class="text-gray-500">Downpayment:</span> <div class="font-medium">{{ $customer->financial->downpayment ?? '—' }}</div></div>
                        <div><span class="text-gray-500">Term:</span> <div class="font-medium">{{ $customer->financial->term ?? '—' }}</div></div>
                        <div><span class="text-gray-500">Monthly:</span> <div class="font-medium">{{ $customer->financial->monthly_amortization ?? '—' }}</div></div>

                        <div><span class="text-gray-500">Rebate:</span> <div class="font-medium">{{ $customer->financial->rebate ?? '—' }}</div></div>
                        <div><span class="text-gray-500">PN Value:</span> <div class="font-medium">{{ $customer->financial->pn_value ?? '—' }}</div></div>
                        <div><span class="text-gray-500">TIP:</span> <div class="font-medium">{{ $customer->financial->tip ?? '—' }}</div></div>
                        <div><span class="text-gray-500">AF:</span> <div class="font-medium">{{ $customer->financial->amount_financed ?? '—' }}</div></div>

                        <div><span class="text-gray-500">Finance Charges:</span> <div class="font-medium">{{ $customer->financial->finance_charges ?? '—' }}</div></div>
                        <div><span class="text-gray-500">AOC:</span> <div class="font-medium">{{ $customer->financial->aoc ?? '—' }}</div></div>
                        <div><span class="text-gray-500">First Due:</span> <div class="font-medium">{{ $customer->financial->first_due_date ?? '—' }}</div></div>
                        <div><span class="text-gray-500">Maturity:</span> <div class="font-medium">{{ $customer->financial->maturity_date ?? '—' }}</div></div>

                        <div><span class="text-gray-500">DP CR No:</span> <div class="font-medium">{{ $customer->financial->downpayment_cr_no ?? '—' }}</div></div>
                        <div class="md:col-span-3"><span class="text-gray-500">Account #:</span> <div class="font-medium">{{ $customer->financial->account_number ?? '—' }}</div></div>
                    </div>
                @else
                    <p class="text-sm text-gray-500">No financial record found.</p>
                @endif
            </div>

            {{-- Audits --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-4">Audit Logs</h3>

                @if($customer->audits->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="text-left text-gray-500">
                                    <th class="py-2 pr-4">Date</th>
                                    <th class="py-2 pr-4">Action</th>
                                    <th class="py-2 pr-4">Actor</th>
                                    <th class="py-2 pr-4">Role</th>
                                    <th class="py-2 pr-4">Field</th>
                                    <th class="py-2 pr-4">New Value</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @foreach($customer->audits as $audit)
                                    <tr>
                                        <td class="py-2 pr-4">{{ $audit->created_at }}</td>
                                        <td class="py-2 pr-4">{{ $audit->action }}</td>
                                        <td class="py-2 pr-4">{{ $audit->actor_id }}</td>
                                        <td class="py-2 pr-4">{{ $audit->actor_role }}</td>
                                        <td class="py-2 pr-4">{{ $audit->field ?? '—' }}</td>
                                        <td class="py-2 pr-4">{{ $audit->new_value ?? '—' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-sm text-gray-500">No audit logs yet.</p>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
