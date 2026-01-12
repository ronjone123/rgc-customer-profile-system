<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">
                Branches
            </h2>

            <a href="{{ route('superadmin.dashboard') }}"
               class="text-sm text-gray-600 hover:underline">
                ← Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto bg-white p-6 rounded shadow">

        {{-- Top actions --}}
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <a href="{{ route('superadmin.branches.index') }}"
                   class="px-3 py-1 text-xs font-semibold rounded
                   {{ ($show ?? 'active') === 'active' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Active
                </a>

                <a href="{{ route('superadmin.branches.index', ['show' => 'archived']) }}"
                   class="px-3 py-1 text-xs font-semibold rounded
                   {{ ($show ?? 'active') === 'archived' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Archived
                </a>

                <a href="{{ route('superadmin.branches.index', ['show' => 'deleted']) }}"
                   class="px-3 py-1 text-xs font-semibold rounded
                   {{ ($show ?? 'active') === 'deleted' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Deleted
                </a>
            </div>

            <a href="{{ route('superadmin.branches.create') }}"
               class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
                ➕ Create Branch
            </a>
        </div>

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
                    <th class="px-6 py-3 border-b text-left">Branch</th>
                    <th class="px-6 py-3 border-b text-center">Status</th>
                    <th class="px-6 py-3 border-b text-center">Total Admins</th>
                    <th class="px-6 py-3 border-b text-center">Active</th>
                    <th class="px-6 py-3 border-b text-center">Suspended</th>
                    <th class="px-6 py-3 border-b text-right">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse ($branches as $branch)
                    <tr class="{{ $branch->trashed() ? 'bg-red-50' : ($branch->isArchived() ? 'bg-gray-50' : '') }}">
                        <td class="px-6 py-4 font-medium">
                            {{ $branch->name }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            @if ($branch->trashed())
                                <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-700">
                                    Deleted
                                </span>
                            @elseif ($branch->isArchived())
                                <span class="px-2 py-1 text-xs rounded bg-gray-200 text-gray-700">
                                    Archived
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">
                                    Active
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-center">
                            {{ $branch->total_admins }}
                        </td>

                        <td class="px-6 py-4 text-center text-green-600">
                            {{ $branch->active_admins }}
                        </td>

                        <td class="px-6 py-4 text-center text-red-600">
                            {{ $branch->suspended_admins }}
                        </td>

                        <td class="px-6 py-4 text-right space-x-2">
                            {{-- DELETED actions --}}
                            @if ($branch->trashed())
                                <form action="{{ route('superadmin.branches.undelete', $branch->id) }}"
                                      method="POST"
                                      class="inline"
                                      onsubmit="return confirm('Restore this deleted branch?');">
                                    @csrf
                                    @method('PATCH')

                                    <button class="inline-flex px-3 py-1 text-xs font-semibold rounded bg-green-100 text-green-800 hover:bg-green-200">
                                        Undelete
                                    </button>
                                </form>

                                <form action="{{ route('superadmin.branches.forceDelete', $branch->id) }}"
                                      method="POST"
                                      class="inline"
                                      onsubmit="return confirm('PERMANENT DELETE. This cannot be undone. Continue?');">
                                    @csrf
                                    @method('DELETE')

                                    <button class="inline-flex px-3 py-1 text-xs font-semibold rounded bg-red-200 text-red-800 hover:bg-red-300">
                                        Force Delete
                                    </button>
                                </form>

                            {{-- ACTIVE/ARCHIVED actions --}}
                            @else
                                {{-- Strict archive mode: no editing when archived --}}
                                @if (! $branch->isArchived())
                                    <a href="{{ route('superadmin.branches.edit', $branch->id) }}"
                                       class="inline-flex px-3 py-1 text-xs font-semibold rounded bg-indigo-100 text-indigo-700 hover:bg-indigo-200">
                                        Edit
                                    </a>
                                @endif

                                @if (! $branch->isArchived())
                                    <form action="{{ route('superadmin.branches.archive', $branch->id) }}"
                                          method="POST"
                                          class="inline"
                                          onsubmit="return confirm('Archive this branch? It will no longer be selectable for new assignments.');">
                                        @csrf
                                        @method('PATCH')

                                        <button class="inline-flex px-3 py-1 text-xs font-semibold rounded bg-yellow-100 text-yellow-800 hover:bg-yellow-200">
                                            Archive
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('superadmin.branches.restore', $branch->id) }}"
                                          method="POST"
                                          class="inline">
                                        @csrf
                                        @method('PATCH')

                                        <button class="inline-flex px-3 py-1 text-xs font-semibold rounded bg-green-100 text-green-800 hover:bg-green-200">
                                            Restore
                                        </button>
                                    </form>
                                @endif

                                {{-- Soft delete button (recoverable) --}}
                                @if (($branch->users_count ?? 0) == 0)
                                    <form action="{{ route('superadmin.branches.destroy', $branch->id) }}"
                                          method="POST"
                                          class="inline"
                                          onsubmit="return confirm('Delete this branch? It will be recoverable (soft delete). Continue?');">
                                        @csrf
                                        @method('DELETE')

                                        <button class="inline-flex px-3 py-1 text-xs font-semibold rounded bg-red-100 text-red-700 hover:bg-red-200">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            No branches found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</x-app-layout>
