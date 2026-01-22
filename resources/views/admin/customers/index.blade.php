<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Customers
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto bg-white p-6 rounded shadow">
        @if($customers->count() === 0)
            <div class="text-gray-500">No customers found.</div>
        @else
            <table class="w-full text-sm">
                <thead>
                    <tr>
                        <th class="text-left p-2">Customer</th>
                        <th class="text-left p-2">Branch</th>
                        <th class="text-left p-2">Created By</th>
                        <th class="text-left p-2">Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customers as $customer)
                        <tr class="border-t">
                            <td class="p-2">{{ $customer->full_name }}</td>
                            <td class="p-2">{{ $customer->branch?->name ?? '—' }}</td>
                            <td class="p-2">{{ $customer->creator?->name ?? '—' }}</td>
                            <td class="p-2">{{ $customer->created_at?->format('M d, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">{{ $customers->links() }}</div>
        @endif
    </div>
</x-app-layout>
