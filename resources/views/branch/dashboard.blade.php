<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">
                Branch Dashboard
            </h2>

            <span class="text-sm text-gray-600">
                {{ $branch->name }}
            </span>
        </div>
    </x-slot>
    <a href="{{ route('branch.users.index') }}"
   class="inline-flex mt-4 bg-indigo-600 hover:bg-indigo-700 text-dark px-4 py-2 rounded">
    View Users
</a>


    <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
        <div class="flex items-center justify-between mb-4">
            <div>
                <div class="text-sm text-gray-500">Branch Status</div>

                @if ($branch->isArchived())
                    <span class="inline-block mt-1 px-2 py-1 text-xs rounded bg-gray-200 text-gray-700">
                        Archived
                    </span>
                @else
                    <span class="inline-block mt-1 px-2 py-1 text-xs rounded bg-green-100 text-green-700">
                        Active
                    </span>
                @endif
            </div>

            <div class="text-sm text-gray-500">
                Branch ID: <span class="text-gray-800 font-medium">{{ $branch->id }}</span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="p-4 rounded border">
                <div class="text-sm text-gray-500">Branch Admins</div>
                <div class="text-2xl font-bold">{{ $branch->branch_admins_count }}</div>
                <div class="text-xs text-gray-400 mt-1">Usually 1 for now</div>
            </div>

            <div class="p-4 rounded border">
                <div class="text-sm text-gray-500">Users</div>
                <div class="text-2xl font-bold">{{ $branch->users_count }}</div>
                <div class="text-xs text-gray-400 mt-1">Customer/users in this branch</div>
            </div>
        </div>

        @if ($branch->isArchived())
            <div class="mt-6 p-3 rounded bg-yellow-50 text-yellow-800 text-sm border border-yellow-200">
                This branch is archived. New assignments are blocked.
            </div>
        @endif
    </div>
</x-app-layout>
