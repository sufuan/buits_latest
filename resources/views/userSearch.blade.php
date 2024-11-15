<!-- resources/views/backend/pages/users/search.blade.php -->

@extends('layouts.landing') <!-- Your main layout file -->

@section('content')
<main>
<div class="container mt-5">
    <h2>User Search</h2>

    <!-- Search Form -->
    <form action="{{ route('users.search') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by Email, Phone, or Member ID" value="{{ old('search', $searchTerm) }}">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>

    <!-- Users Table -->
    @if(count($users) > 0)
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Member ID</th>
                    <th>Department</th>
                    <th>Session</th>
                    
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->member_id }}</td>
                    <td>{{ $user->department }}</td>
                    <td>{{ $user->session }}</td>
                   
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <p class="text-center">No users found.</p>
    @endif
</div>
</main>
@endsection
