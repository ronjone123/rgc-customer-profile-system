@extends('layouts.app')

@section('content')
<div class="container">

    <h2>Create New Admin</h2>

    <form method="POST" action="{{ route('superadmin.admins.store') }}">
        @csrf

        <div class="mb-3">
            <label>Name</label>
            <input name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input name="email" type="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input name="password" type="password" class="form-control" required>
        </div>

        <button class="btn btn-success">Create Admin</button>
    </form>

</div>
@endsection
