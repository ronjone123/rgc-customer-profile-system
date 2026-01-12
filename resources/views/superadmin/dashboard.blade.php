<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-dark-200 leading-tight">
            Super Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="p-6 bg-white dark:bg-white-800 overflow-hidden shadow-sm rounded-lg">
                    <h5 class="text-dark-600 dark:text-dark-300">Total Admins</h5>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-dark">
                        {{ \App\Models\User::where('is_admin', 1)->count() }}
                    </h2>
                </div>

                <div class="p-6 bg-white dark:bg-white-800 overflow-hidden shadow-sm rounded-lg">
                    <h5 class="text-dark-600 dark:text-dark-300">Total Staff Users</h5>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-dark">
                        {{ \App\Models\User::where('is_user', 1)->count() }}
                    </h2>
                </div>

                <div class="p-6 bg-white dark:bg-white-800 overflow-hidden shadow-sm rounded-lg">
                    <h5 class="text-dark-600 dark:text-dark-300">Total Accounts</h5>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-dark">
                        {{ \App\Models\User::count() }}
                    </h2>
                </div>

            </div>

            <!-- Buttons -->
            <div class="mt-8 flex gap-4">
                <a href="/superadmin/admins" 
                   class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-dark rounded-lg">
                    View Admins
                </a>

                <a href="/superadmin/admins/create" 
                   class="px-4 py-2 bg-green-600 hover:bg-green-700 text-dark rounded-lg">
                    ➕ Create New Admin
                </a>
                <a href="/superadmin/users/create"
                   class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-dark rounded-lg">
                    ➕ Create New Users →
                </a>
                <a href="{{ route('superadmin.branches.index') }}"
                   class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-dark rounded-lg">
                   View Branches →
                </a>
            </div>

        </div>
    </div>

</x-app-layout>
