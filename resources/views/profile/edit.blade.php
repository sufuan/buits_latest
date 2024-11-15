@extends('layouts.app')

@section('title')
Edit Profile - {{ $user->name }}
@endsection

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

<style>
    .form-check-label {
        text-transform: capitalize;
    }
</style>
@endsection

@section('content')

<main>
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-xl px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon">
                                <i data-feather="user"></i>
                            </div>
                            Edit User - {{ $user->name }}
                        </h1>
                    </div>

                </div>
            </div>
        </div>
    </header>
    @include('backend.layouts.partials.messages')

    <!-- Main page content-->
    <div class="container-xl px-4 mt-4">
        <div class="row">
            <div class="col-xl-4">
                <!-- Profile picture card-->
                <div class="card mb-4 mb-xl-0">
                    <div class="card-header">Profile Picture</div>
                    <div class="card-body text-center">
                        <!-- Display the user's profile picture if available, otherwise a placeholder -->
                        <img class="img-account-profile rounded-circle mb-2" src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('assets/img/demo/user-placeholder.svg') }}" alt="Profile Picture" />

                        <!-- Profile picture upload help text -->
                        <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 1 MB</div>

                        <!-- Profile picture upload form -->
                        <form action="{{ route('profile.uploadImage') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="image" class="form-control mb-3" accept="image/*" required>
                            <button class="btn btn-primary" type="submit">Upload New Image</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-xl-8">
                <!-- Account details card-->
                <div class="card mb-4">
                    <div class="card-header">Account Details</div>
                    <div class="card-body">
                        <form action="{{ route('profile.update') }}" method="POST">
                            @method('PATCH') <!-- Changed to PATCH for updating -->
                            @csrf
                            <!-- Form Row-->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (name)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputName">User Name</label>
                                    <input class="form-control" id="inputName" type="text" name="name" placeholder="Enter Name" value="{{ $user->name }}" />
                                </div>
                                <!-- Form Group (email)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputEmailAddress">User Email</label>
                                    <input class="form-control" id="inputEmailAddress" type="email" name="email" placeholder="Enter Email" value="{{ $user->email }}" />
                                </div>
                            </div>
                            <!-- Form Row (password and confirm password)-->
                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label for="password" class="small mb-1">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
                                </div>
                                <div class="col-md-6">
                                    <label for="password_confirmation" class="small mb-1">Confirm Password</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Enter Password">
                                </div>
                            </div>
                            <!-- Additional fields -->
                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputPhone">Phone</label>
                                    <input class="form-control" id="inputPhone" type="text" name="phone" placeholder="Enter Phone" value="{{ $user->phone }}" />
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputSession">Session</label>
                                    <select id="session" name="session" class="block mt-1 w-full bg-white" required>
                                        @php
                                        $currentYear = date('Y');
                                        $startYear = 2015; // Starting from 2015-2016
                                        @endphp
                                        @for ($year = $startYear; $year <= $currentYear; $year++)
                                            <option value="{{ $year }}-{{ $year + 1 }}">{{ $year }}-{{ $year + 1 }}</option>
                                            @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputDepartment">Department</label>
                                    <select id="inputDepartment" name="department" class="form-control" required>
                                        @foreach ($departments as $department)
                                        <option value="{{ $department }}" {{ $user->department === $department ? 'selected' : '' }}>
                                            {{ $department }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputGender">Gender</label>
                                    <select name="gender" id="inputGender" class="form-control">
                                        <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputDateOfBirth">Date of Birth</label>
                                    <input class="form-control" id="inputDateOfBirth" type="date" name="date_of_birth" value="{{ $user->date_of_birth }}" />
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputBloodGroup">Blood Group</label>
                                    <select name="blood_group" id="inputBloodGroup" class="form-control">
                                        <option value="A+" {{ $user->blood_group == 'A+' ? 'selected' : '' }}>A+</option>
                                        <option value="A-" {{ $user->blood_group == 'A-' ? 'selected' : '' }}>A-</option>
                                        <option value="B+" {{ $user->blood_group == 'B+' ? 'selected' : '' }}>B+</option>
                                        <option value="B-" {{ $user->blood_group == 'B-' ? 'selected' : '' }}>B-</option>
                                        <option value="AB+" {{ $user->blood_group == 'AB+' ? 'selected' : '' }}>AB+</option>
                                        <option value="AB-" {{ $user->blood_group == 'AB-' ? 'selected' : '' }}>AB-</option>
                                        <option value="O+" {{ $user->blood_group == 'O+' ? 'selected' : '' }}>O+</option>
                                        <option value="O-" {{ $user->blood_group == 'O-' ? 'selected' : '' }}>O-</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputClassRoll">Class Roll</label>
                                    <input class="form-control" id="inputClassRoll" type="text" name="class_roll" placeholder="Enter Class Roll" value="{{ $user->class_roll }}" />
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputFatherName">Father's Name</label>
                                    <input class="form-control" id="inputFatherName" type="text" name="father_name" placeholder="Enter Father's Name" value="{{ $user->father_name }}" />
                                </div>
                            </div>
                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputMotherName">Mother's Name</label>
                                    <input class="form-control" id="inputMotherName" type="text" name="mother_name" placeholder="Enter Mother's Name" value="{{ $user->mother_name }}" />
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputCurrentAddress">Current Address</label>
                                    <input class="form-control" id="inputCurrentAddress" type="text" name="current_address" placeholder="Enter Current Address" value="{{ $user->current_address }}" />
                                </div>
                            </div>
                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputPermanentAddress">Permanent Address</label>
                                    <input class="form-control" id="inputPermanentAddress" type="text" name="permanent_address" placeholder="Enter Permanent Address" value="{{ $user->permanent_address }}" />
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputSkills">Skills</label>
                                    <input class="form-control" id="inputSkills" type="text" name="skills" placeholder="Enter Skills" value="{{ $user->skills }}" />
                                </div>
                            </div>
                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputTransactionId">Transaction ID</label>
                                    <input class="form-control" id="inputTransactionId" type="text" name="transaction_id" placeholder="Enter Transaction ID" value="{{ $user->transaction_id }}" />
                                </div>
                                <!-- Add more fields as needed -->
                            </div>
                            <!-- Form Group (roles)-->

                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Save User</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection