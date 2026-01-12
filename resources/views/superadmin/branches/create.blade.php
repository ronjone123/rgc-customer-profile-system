<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">
                Create Branch
            </h2>

            <a href="{{ route('superadmin.branches.index') }}"
               class="text-sm text-gray-600 hover:underline">
                ← Back to Branches
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">

            @if ($errors->any())
                <div class="mb-4 text-red-600">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('superadmin.branches.store') }}">
                @csrf

                <div class="mb-6">
                    <label class="block font-medium mb-1">Branch Name</label>
                    <input type="text"
                           name="name"
                           value="{{ old('name') }}"
                           class="w-full border rounded px-3 py-2"
                           placeholder="e.g. Main Branch"
                           required>
                </div>

                <div class="flex justify-center">
                    <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-dark px-4 py-2 rounded">
                        Create Branch
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
