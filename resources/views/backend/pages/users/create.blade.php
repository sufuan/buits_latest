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

<!-- page title area start -->

<!-- page title area end -->

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
    @include('backend.layouts.partials.messages')

    <!-- Main page content-->
    <div class="container-xl px-4 mt-4">
        <div class="row">
            <div class="col-xl-4">
                <!-- Profile picture card-->
                <div class="card mb-4 mb-xl-0">
                    <div class="card-header">Profile Picture</div>
                    <div class="card-body text-center">
                        <!-- Profile picture image-->
                        <img class="img-account-profile rounded-circle mb-2" src="{{ asset('assets/img/demo/user-placeholder.svg') }}" alt="" />

                        <!-- Profile picture help block-->
                        <div class="small font-italic text-muted mb-4">
                            JPG or PNG no larger than 5 MB
                        </div>
                        <!-- Profile picture upload button-->
                        <button class="btn btn-primary" type="button">
                            Upload new image
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <!-- Account details card-->
                <div class="card mb-4">
                    <div class="card-header">Account Details</div>
                    <div class="card-body">
                        <form action="{{ route('admin.users.store') }}" method="POST">
                            @csrf
                            <!-- Form Row-->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (first name)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputFirstName">First name *</label>
                                    <input class="form-control" id="inputFirstName" type="text" name="name" placeholder="Enter your first name" value="" required />
                                </div>
                                <!-- Form Group (last name)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputLastName">Last name</label>
                                    <input class="form-control" id="inputLastName" type="text" name="last_name" placeholder="Enter your last name" value="" />
                                </div>
                            </div>
                            <!-- Form Group (email address)-->
                            <div class="mb-3">
                                <label class="small mb-1" for="inputEmailAddress">Email address *</label>
                                <input class="form-control" id="inputEmailAddress" type="email" name="email" placeholder="Enter your email address" value="" required />
                            </div>
                            <!-- Form Row (password and confirm password)-->
                            <div class="row gx-3 mb-3">
                                <div class="col-md-6 col-sm-12">
                                    <label for="password" class="small mb-1">Password *</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <label for="password_confirmation" class="small mb-1">Confirm Password *</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required>
                                </div>
                            </div>

                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputPhone">Phone *</label>
                                    <input class="form-control" id="inputPhone" type="text" name="phone" placeholder="Enter phone number" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputSession">Session</label>
                                    <input class="form-control" id="inputSession" type="text" name="session" placeholder="Enter session">
                                </div>
                            </div>


                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputDepartment">Department</label>
                                    <input class="form-control" id="inputDepartment" type="text" name="department" placeholder="Enter department">
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputGender">Gender</label>
                                    <select class="form-select" id="inputGender" name="gender">
                                        <option value="">Select gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputDateOfBirth">Date of Birth</label>
                                    <input class="form-control" id="inputDateOfBirth" type="date" name="date_of_birth">
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputBloodGroup">Blood Group *</label>
                                    <select class="form-select" id="inputBloodGroup" name="blood_group" required>
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
                                </div>
                            </div>

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

                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputTransactionId">Transaction ID *</label>
                                    <input class="form-control" id="inputTransactionId" type="text" name="transaction_id" placeholder="Enter transaction ID" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Save User</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection

@section('scripts')

@endsection