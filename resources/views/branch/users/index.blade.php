<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">
                Users
            </h2>

            <a href="{{ route('branch.dashboard') }}"
               class="text-sm text-gray-600 hover:underline">
                ← Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto bg-white p-6 rounded shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="text-sm text-gray-600">
                Branch: <span class="font-semibold text-gray-800">{{ $branch->name }}</span>
            </div>

            <div class="text-sm text-gray-600">
                Total: <span class="font-semibold">{{ $users->total() }}</span>
            </div>
        </div>

        <table class="w-full border border-gray-200 text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 border-b text-left">Name</th>
                    <th class="px-6 py-3 border-b text-left">Email</th>
                    <th class="px-6 py-3 border-b text-center">Status</th>
                    <th class="px-6 py-3 border-b text-left">Created</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse ($users as $user)
                    <tr>
                        <td class="px-6 py-4 font-medium">{{ $user->name }}</td>
                        <td class="px-6 py-4">{{ $user->email }}</td>

                        <td class="px-6 py-4 text-center">
                            @if ($user->status === 'active')
                                <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">Active</span>
                            @elseif ($user->status === 'suspended')
                                <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-700">Suspended</span>
                            @else
                                <span class="px-2 py-1 text-xs rounded bg-gray-200 text-gray-700">
                                    {{ ucfirst($user->status ?? 'unknown') }}
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-gray-600">
                            {{ $user->created_at?->format('Y-m-d') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                            No users found in this branch.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>
