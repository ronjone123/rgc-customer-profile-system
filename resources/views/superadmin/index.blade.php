@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Admins</h2>

    <a href="{{ route('superadmin.admins.create') }}" class="btn btn-primary mb-3">➕ Create Admin</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Date Created</th>
            </tr>
        </thead>

        <tbody>
            @foreach($admins as $admin)
            <tr>
                <td>{{ $admin->name }}</td>
                <td>{{ $admin->email }}</td>
                <td>{{ $admin->created_at->format('M d, Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
