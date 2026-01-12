<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">
                Create Admin
            </h2>

            <x-back-button
                href="{{ route('superadmin.admins.index') }}"
                label="Back to Admins"
            />
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="mb-4 text-red-600">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('superadmin.admins.store') }}">
                @csrf

                {{-- Name --}}
                <div class="mb-4">
                    <label class="block font-medium">Name</label>
                    <input type="text"
                           name="name"
                           class="w-full border rounded px-3 py-2"
                           value="{{ old('name') }}"
                           required>
                </div>

                {{-- Email --}}
                <div class="mb-4">
                    <label class="block font-medium">Email</label>
                    <input type="email"
                           name="email"
                           class="w-full border rounded px-3 py-2"
                           value="{{ old('email') }}"
                           required>
                </div>

                {{-- Role --}}
                <div class="mb-4">
                    <label class="block font-medium">Role</label>
                    <select name="role"
                            class="w-full border rounded px-3 py-2"
                            required>
                        <option value="">-- Select Role --</option>
                        <option value="head_admin"
                            @selected(old('role') === 'head_admin')>
                            Head Office Admin
                        </option>
                        <option value="branch_admin"
                            @selected(old('role') === 'branch_admin')>
                            Branch Admin
                        </option>
                    </select>
                </div>

                {{-- Branch --}}
                <div class="mb-4">
                    <label class="block font-medium">
                        Branch <span class="text-gray-400">(required for Branch Admin)</span>
                    </label>

                    @if ($branches->count() === 0)
                        <div class="p-3 rounded bg-yellow-50 text-yellow-800 text-sm border border-yellow-200">
                            No active branches available. Create or restore a branch first.
                        </div>
                    @endif

                    <select id="branch_id"
                            name="branch_id"
                            class="w-full border rounded px-3 py-2"
                            {{ $branches->count() === 0 ? 'disabled' : '' }}>
                        <option value="">-- Select Branch --</option>

                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}" @selected(old('branch_id') == $branch->id)>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('branch_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Password --}}
                <div class="mb-4">
                    <label class="block font-medium">Password</label>
                    <input type="password"
                           name="password"
                           class="w-full border rounded px-3 py-2"
                           required>
                </div>

                {{-- Confirm Password --}}
                <div class="mb-6">
                    <label class="block font-medium">Confirm Password</label>
                    <input type="password"
                           name="password_confirmation"
                           class="w-full border rounded px-3 py-2"
                           required>
                </div>

                {{-- Actions --}}
                <div class="flex justify-center">
                    <button type="submit"
                            class="bg-blue-600 text-dark px-4 py-2 rounded hover:bg-blue-700">
                        Create Admin
                    </button>
                </div>
            </form>

        </div>
    </div>
        <script>
    document.addEventListener('DOMContentLoaded', () => {
        const role = document.querySelector('select[name="role"]');
        const branch = document.getElementById('branch_id');

        const sync = () => {
            const isBranchAdmin = role.value === 'branch_admin';

            // if there are no branches, keep disabled no matter what
            const noBranches = branch.hasAttribute('disabled') && branch.options.length <= 1;

            if (noBranches) return;

            branch.disabled = !isBranchAdmin;

            // Optional: clear branch when switching to head_admin
            if (!isBranchAdmin) {
                branch.value = '';
            }
        };

        role.addEventListener('change', sync);
        sync(); // run once on load (supports old('role'))
    });
    </script>
</x-app-layout>
