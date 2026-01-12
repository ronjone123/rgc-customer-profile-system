<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">
                Create User
            </h2>

            <a href="{{ route('superadmin.users.index') }}"
               class="text-sm text-gray-600 hover:underline">
                ← Back to Users
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="mb-4 p-3 rounded bg-red-100 text-red-800">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('superadmin.users.store') }}">
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

                {{-- Branch --}}
                <div class="mb-4">
                    <label class="block font-medium">Branch</label>
                    <select name="branch_id"
                            class="w-full border rounded px-3 py-2"
                            required>
                        <option value="">-- Select Branch (Active Only) --</option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}"
                                @selected(old('branch_id') == $branch->id)>
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
                <div class="flex justify-end">
                    <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
                        Create User
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>