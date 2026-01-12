@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4">

    <h1 class="text-2xl font-bold mb-6">Admin Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-gray-500">Total Users</h3>
            <p class="text-3xl font-bold">
                {{ \App\Models\User::where('is_user', 1)->count() }}
            </p>
        </div>

        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-gray-500">Pending Customers</h3>
            <p class="text-3xl font-bold">0</p>
        </div>

        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-gray-500">Applications</h3>
            <p class="text-3xl font-bold">0</p>
        </div>

    </div>

    <div class="mt-8">
        <a href="{{ route('admin.users') }}" class="btn btn-primary">
            Manage Users
        </a>
    </div>

</div>
@endsection
