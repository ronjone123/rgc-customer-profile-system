<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Create User</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.users.store') }}">
                    @csrf

                    <label>Name</label>
                    <input name="name" value="{{ old('name') }}" class="input" />
                    @error('name') <div class="text-red-600">{{ $message }}</div> @enderror

                    <label>Email</label>
                    <input name="email" value="{{ old('email') }}" class="input" />
                    @error('email') <div class="text-red-600">{{ $message }}</div> @enderror

                    <label>Password</label>
                    <input type="password" name="password" class="input" />
                    @error('password') <div class="text-red-600">{{ $message }}</div> @enderror

                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" class="input" />

                    <label style="display:block; margin-top:8px;">
                        <input type="checkbox" name="is_admin" value="1"> Make admin
                    </label>

                    <div style="margin-top:12px;">
                        <button class="btn">Create</button>
                        <a href="{{ route('admin.users.index') }}" class="btn" style="background:#6c757d;">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
