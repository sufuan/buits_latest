@extends('layouts.landing')

@section('content')
<main>
<div class="container mt-5">
    <h1 class="mb-4">Volunteer Registration</h1>

    <!-- Display success message -->
    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif

    <!-- Display validation errors -->
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Member ID Verification Form - Only show if user is not found -->
    @if (!session('user'))
    <form method="POST" action="{{ route('volunteer.verifyMemberId') }}" class="mb-4">
        @csrf

        <!-- Member ID Field -->
        <div class="form-group">
            <label for="member_id">Member ID:</label>
            <input type="text" id="member_id" name="member_id" value="{{ old('member_id') }}" class="form-control" required>
            @error('member_id')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Submit Button for verifying Member ID -->
        <button type="submit" class="btn btn-primary mt-2">Verify Member ID</button>
    </form>
    @endif

    <!-- If user is found, show the full registration form -->
    @if (session('user'))
    @php $user = session('user'); @endphp

    <form method="POST" action="{{ route('volunteer.register') }}">
        @csrf

        <!-- Hidden field to store Member ID -->
        <input type="hidden" name="member_id" value="{{ $user->member_id }}">

        <!-- Name Field -->
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="{{ $user->name }}" class="form-control" required>
            @error('name')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Email Field -->
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="{{ $user->email }}" class="form-control" required>
            @error('email')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Phone Field -->
        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" value="{{ $user->phone }}" class="form-control">
            @error('phone')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Department Field (Dropdown) -->
        <div class="form-group">
            <label for="department">Department:</label>
            <select id="department" name="department" class="form-control" required>
                <option value="">Select Department</option>
                @foreach($departments as $department)
                <option value="{{ $department }}" {{ (old('department', $user->department) == $department) ? 'selected' : '' }}>
                    {{ $department }}
                </option>
                @endforeach
            </select>
            @error('department')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Session Field -->
        <div class="form-group">
            <label for="session">Session:</label>
            <select id="session" name="session" class="form-control" required>
                @php
                $currentYear = date('Y');
                $startYear = 2015; // Starting from 2015-2016
                @endphp
                @for ($year = $startYear; $year <= $currentYear; $year++)
                    <option value="{{ $year }}-{{ $year + 1 }}" {{ old('session') == "$year-" . ($year + 1) ? 'selected' : '' }}>
                    {{ $year }}-{{ $year + 1 }}
                    </option>
                @endfor
            </select>
            @error('session')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-success">Register</button>
    </form>
    @endif
</div>
</main>
@endsection
