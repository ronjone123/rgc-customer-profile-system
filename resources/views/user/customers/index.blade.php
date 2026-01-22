<x-app-layout>
    <div class="max-w-6xl mx-auto bg-white p-6 rounded shadow">
        {{-- Flash messages --}}
        @if (session('success'))
            <div class="mb-4 p-3 rounded bg-green-100 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-3 rounded bg-red-100 text-red-800">
                {{ session('error') }}
            </div>
        @endif

        <table class="w-full border border-gray-200 text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 border-b text-left">Customer</th>
                    <th class="px-6 py-3 border-b text-left">Created By</th>
                    <th class="px-6 py-3 border-b text-left">Created At</th>
                    <th class="px-6 py-3 border-b text-left">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse ($customers as $customer)
                    <tr>
                        <td class="px-6 py-4 font-medium">
                            {{ $customer->full_name }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $customer->creator?->name ?? '—' }}
                        </td>

                        <td class="px-6 py-4 text-gray-600">
                            {{ $customer->created_at?->format('M d, Y h:i A') ?? '—' }}
                        </td>

                        <td class="px-6 py-4">
                            <a href="{{ route('user.customers.show', $customer) }}"
                               class="text-blue-600 hover:underline">
                                View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-6 text-center text-gray-500">
                            No customers yet. Click “New Customer” to add one.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $customers->links() }}
        </div>
    </div>
</x-app-layout>
