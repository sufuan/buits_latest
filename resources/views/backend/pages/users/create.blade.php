@extends('backend.layouts.master')

@section('title')
User Create - Admin Panel
@endsection

@section('styles')
<style>
    .form-check-label {
        text-transform: capitalize;
    }
</style>
@endsection

@section('admin-content')
<main>
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-xl px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon">
                                <i data-feather="user-plus"></i>
                            </div>
                            Add User
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" href="{{ route('admin.users.index') }}">
                            <i class="me-1" data-feather="arrow-left"></i>
                            Back to Users List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main page content-->
    <div class="container-xl px-4 mt-4">
        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <!-- Profile picture card-->
                <div class="col-xl-4">
                    <div class="card mb-4 mb-xl-0">
                        <div class="card-header">Profile Picture</div>
                        <div class="card-body text-center">
                            <!-- Profile picture image-->
                            <img class="img-account-profile rounded-circle mb-2" src="{{ asset('assets/img/demo/user-placeholder.svg') }}" alt="User Placeholder" />

                            <!-- Profile picture help block-->
                            <div class="small font-italic text-muted mb-4">
                                JPG or PNG no larger than 2 MB
                            </div>

                            <!-- Profile picture upload input-->
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                            @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Account details card-->
                <div class="col-xl-8">
                    <div class="card mb-4">
                        <div class="card-header">Account Details</div>
                        <div class="card-body">
                            <!-- Form Group (name)-->
                            <div class="row gx-3 mb-3">
                                <div class="col-md-12">
                                    <label class="small mb-1" for="inputFirstName">Name *</label>
                                    <input class="form-control @error('name') is-invalid @enderror" id="inputFirstName" type="text" name="name" placeholder="Enter your name" value="{{ old('name') }}" required />
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Form Row (email and password)-->
                            <div class="row gx-3 mb-3">
                                <div class="col-md-6 col-sm-12">
                                    <label class="small mb-1" for="inputEmailAddress">Email address *</label>
                                    <input class="form-control @error('email') is-invalid @enderror" id="inputEmailAddress" type="email" name="email" placeholder="Enter your email address" value="{{ old('email') }}" required />
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-sm-12">
                                    <label for="password" class="small mb-1">Password *</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Enter Password" required>
                                    @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Form Row (phone and session)-->
                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputPhone">Phone *</label>
                                    <input class="form-control @error('phone') is-invalid @enderror" id="inputPhone" type="text" name="phone" placeholder="Enter phone number" required>
                                    @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputSession">Session</label>
                                    <select id="session" name="session" class="form-select @error('session') is-invalid @enderror" required>
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
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <!-- Form Row (department and gender)-->
                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputDepartment">Department *</label>
                                    <select class="form-select @error('department') is-invalid @enderror" id="inputDepartment" name="department" required>
                                        <option value="">Select Department</option>
                                        @foreach($departments as $department)
                                        <option value="{{ $department }}" {{ old('department') == $department ? 'selected' : '' }}>{{ $department }}</option>
                                        @endforeach
                                    </select>
                                    @error('department')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputGender">Gender</label>
                                    <select class="form-select @error('gender') is-invalid @enderror" id="inputGender" name="gender">
                                        <option value="">Select gender</option>
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Form Row (date of birth and blood group)-->
                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputDateOfBirth">Date of Birth</label>
                                    <input class="form-control @error('date_of_birth') is-invalid @enderror" id="inputDateOfBirth" type="date" name="date_of_birth">
                                    @error('date_of_birth')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputBloodGroup">Blood Group *</label>
                                    <select class="form-select @error('blood_group') is-invalid @enderror" id="inputBloodGroup" name="blood_group" required>
                                        <option value="">Select blood group</option>
                                        <option value="A+">A+</option>
                                        <option value="A-">A-</option>
                                        <option value="B+">B+</option>
                                        <option value="B-">B-</option>
                                        <option value="O+">O+</option>
                                        <option value="O-">O-</option>
                                        <option value="AB+">AB+</option>
                                        <option value="AB-">AB-</option>
                                    </select>
                                    @error('blood_group')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Form Row (class roll and father's name)-->
                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputClassRoll">Class Roll</label>
                                    <input class="form-control" id="inputClassRoll" type="text" name="class_roll" placeholder="Enter class roll">
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputFatherName">Father's Name</label>
                                    <input class="form-control" id="inputFatherName" type="text" name="father_name" placeholder="Enter father's name">
                                </div>
                            </div>

                            <!-- Form Row (mother's name and current address)-->
                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputMotherName">Mother's Name</label>
                                    <input class="form-control" id="inputMotherName" type="text" name="mother_name" placeholder="Enter mother's name">
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputCurrentAddress">Current Address</label>
                                    <textarea class="form-control" id="inputCurrentAddress" name="current_address" placeholder="Enter current address"></textarea>
                                </div>
                            </div>

                            <!-- Form Row (permanent address and skills)-->
                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputPermanentAddress">Permanent Address</label>
                                    <textarea class="form-control" id="inputPermanentAddress" name="permanent_address" placeholder="Enter permanent address"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputSkills">Skills</label>
                                    <input class="form-control" id="inputSkills" type="text" name="skills" placeholder="Enter skills">
                                </div>
                            </div>

                            <!-- Form Row (transaction ID)-->
                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputTransactionId">Transaction ID *</label>
                                    <input class="form-control @error('transaction_id') is-invalid @enderror" id="inputTransactionId" type="text" name="transaction_id" placeholder="Enter transaction ID" required>
                                    @error('transaction_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Save User</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>
@endsection

@section('scripts')
<!-- Additional scripts (if needed) -->
@endsection