@extends('layouts.master')

@section('title', 'Users')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">Users List</h2>

    <!-- Search Form -->
    <form method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by name or email" value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Search</button>
            <a href="{{ route('crud.index') }}" class="btn btn-danger">Reset</a>
        </div>
    </form>

    <a href="{{ route('crud.create') }}" class="btn btn-success mb-3">Add User</a>

    <!-- Users Table -->
    <table class="table table-bordered table-hover">
        <thead class="table-success">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <a href="{{ route('crud.edit', $user) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('crud.destroy', $user) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $users->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
