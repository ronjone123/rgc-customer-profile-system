<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Admins
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto bg-white p-6 rounded shadow">

        {{-- Actions --}}
        <div class="mb-4 flex justify-between items-center">
            <a href="{{ route('superadmin.dashboard') }}"
               class="text-sm text-gray-600 hover:text-gray-900">
                ← Back to Dashboard
            </a>

            <a href="{{ route('superadmin.admins.create') }}"
               class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-dark px-4 py-2 rounded">
                ➕ Create Admin
            </a>
        </div>

        {{-- Admins Table --}}
        <table class="w-full border border-gray-200 text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 border-b text-left">Name</th>
                    <th class="px-6 py-3 border-b text-left">Email</th>
                    <th class="px-6 py-3 border-b text-left">Role</th>
                    <th class="px-6 py-3 border-b text-left">Status</th>
                    <th class="px-6 py-3 border-b text-right">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse ($admins as $admin)
                    <tr>
                        <td class="px-6 py-4">{{ $admin->name }}</td>
                        <td class="px-6 py-4">{{ $admin->email }}</td>

                        {{-- Role --}}
                        <td class="px-6 py-4">
                            @if ($admin->role === 'head_admin')
                                <span class="px-2 py-1 text-xs rounded bg-blue-100 text-blue-800">
                                    Head Admin
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs rounded bg-purple-100 text-purple-800">
                                    Branch Admin
                                </span>
                            @endif
                        </td>

                        {{-- Status --}}
                        <td class="px-6 py-4">
                            @if ($admin->status === 'active')
                                <span class="text-green-600 font-semibold">Active</span>
                            @else
                                <span class="text-red-600 font-semibold">Suspended</span>
                            @endif
                        </td>

                        {{-- Actions --}}
                        <td class="px-6 py-4 text-right space-x-3">

    <a href="{{ route('superadmin.admins.edit', $admin->id) }}"
   class="inline-flex px-3 py-1 text-xs rounded bg-indigo-100 text-indigo-700">
    Edit
</a>


    {{-- Suspend / Activate --}}
    @if ($admin->status === 'active')
        <form action="{{ route('superadmin.admins.suspend', $admin->id) }}"
              method="POST"
              class="inline">
            @csrf
            @method('PATCH')

            <button
                class="text-red-600 hover:underline"
                onclick="return confirm('Suspend this admin?')">
                Suspend
            </button>
        </form>
    @else
        <form action="{{ route('superadmin.admins.activate', $admin->id) }}"
              method="POST"
              class="inline">
            @csrf
            @method('PATCH')

            <button
                class="text-green-600 hover:underline"
                onclick="return confirm('Activate this admin?')">
                Activate
            </button>
        </form>
    @endif

    {{-- Delete --}}
    <form action="{{ route('superadmin.admins.destroy', $admin->id) }}"
          method="POST"
          class="inline">
        @csrf
        @method('DELETE')

        <button
            class="text-gray-600 hover:text-red-600 hover:underline"
            onclick="return confirm('Delete this admin permanently?')">
            Delete
        </button>
    </form>

</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            No admins found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
