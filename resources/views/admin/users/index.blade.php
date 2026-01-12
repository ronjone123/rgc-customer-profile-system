<x-app-layout>
    <x-slot name="header">
        <div style="display:flex; justify-content:space-between; align-items:center">
            <h2 class="font-semibold text-xl">User Management</h2>
            <a href="{{ route('admin.users.create') }}" class="btn">+ New User</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 text-green-700">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-4 text-red-700">{{ session('error') }}</div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-4">
                <table class="w-full">
                    <thead class="text-left">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Admin</th>
                            <th>Branch</th>
                            <th>Created</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $u)
                        <tr class="border-t">
                            <td>{{ $u->name }}</td>
                            <td>{{ $u->email }}</td>
                            <td>{{ $u->is_admin ? 'Yes' : 'No' }}</td>
                            <td>{{ $u->branch_id ?? '-' }}</td>
                            <td>{{ $u->created_at->format('Y-m-d') }}</td>
                            <td style="text-align:right;">
                                <a href="{{ route('admin.users.edit', $u) }}" class="btn">Edit</a>
                                <form action="{{ route('admin.users.destroy', $u) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Delete user?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn" style="background:#e3342f; color:#fff;">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
