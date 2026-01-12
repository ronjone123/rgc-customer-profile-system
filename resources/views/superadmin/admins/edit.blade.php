<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Edit Admin
        </h2>
    </x-slot>

    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">

        <form method="POST" action="{{ route('superadmin.admins.update', $admin->id) }}">
            @csrf
            @method('PUT')

            {{-- Name --}}
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Name</label>
                <input type="text"
                       name="name"
                       value="{{ old('name', $admin->name) }}"
                       class="w-full border rounded px-3 py-2">
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Email</label>
                <input type="email"
                       name="email"
                       value="{{ old('email', $admin->email) }}"
                       class="w-full border rounded px-3 py-2">
                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Role --}}
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Role</label>
                <select name="role" class="w-full border rounded px-3 py-2">
                    <option value="head_admin"
                        @selected(old('role', $admin->role) === 'head_admin')>
                        Head Admin
                    </option>
                    <option value="branch_admin"
                        @selected(old('role', $admin->role) === 'branch_admin')>
                        Branch Admin
                    </option>
                </select>
                @error('role')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Branch --}}
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">
                    Branch <span class="text-gray-400">(required for Branch Admin)</span>
                </label>

                {{-- If admin currently has a branch_id but it's not in the active list anymore --}}
                @php
                    $currentBranchMissing = $admin->branch_id && !$branches->contains('id', $admin->branch_id);
                @endphp

                @if ($branches->count() === 0)
                    <div class="mb-2 p-3 rounded bg-yellow-50 text-yellow-800 text-sm border border-yellow-200">
                        No active branches available. Restore or create a branch first.
                    </div>
                @endif

                @if ($currentBranchMissing)
                    <div class="mb-2 p-3 rounded bg-gray-50 text-gray-700 text-sm border">
                        This admin is currently assigned to a branch that is archived (or deleted), so it won’t appear in the list.
                        Choose an active branch to reassign them.
                    </div>
                @endif

                <select id="branch_id"
                        name="branch_id"
                        class="w-full border rounded px-3 py-2"
                        {{ $branches->count() === 0 ? 'disabled' : '' }}>
                    <option value="">-- Select Branch --</option>

                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}"
                            @selected(old('branch_id', $admin->branch_id) == $branch->id)>
                            {{ $branch->name }}
                        </option>
                    @endforeach
                </select>

                @error('branch_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>


            {{-- Password (optional reset) --}}
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">
                    New Password <span class="text-gray-400">(leave blank to keep current)</span>
                </label>
                <input type="password"
                       name="password"
                       class="w-full border rounded px-3 py-2">
                @error('password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium mb-1">Confirm New Password</label>
                <input type="password"
                       name="password_confirmation"
                       class="w-full border rounded px-3 py-2">
            </div>

            {{-- Actions --}}
            <div class="flex justify-between items-center">
                <a href="{{ route('superadmin.admins.index') }}"
                   class="text-sm text-gray-600 hover:underline">
                    ← Back
                </a>

                <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
                    Save Changes
                </button>
            </div>

        </form>
    </div>
        <script>
    document.addEventListener('DOMContentLoaded', () => {
        const role = document.querySelector('select[name="role"]');
        const branch = document.getElementById('branch_id');

        const sync = () => {
            const isBranchAdmin = role.value === 'branch_admin';

            // If there are no branches (disabled), don't fight it
            const noBranches = branch.hasAttribute('disabled') && branch.options.length <= 1;
            if (noBranches) return;

            branch.disabled = !isBranchAdmin;

            // Optional: clear branch when switching to head_admin
            if (!isBranchAdmin) {
                branch.value = '';
            }
        };

        role.addEventListener('change', sync);
        sync();
    });
    </script>

</x-app-layout>
