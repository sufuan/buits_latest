@extends('backend.layouts.master')

@section('title')
    User Profile - {{ $user->name }}
@endsection

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
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
                                <i data-feather="user"></i>
                            </div>
                            View User - {{ $user->name }}
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" href="{{ route('admin.users.index') }}">
                            <i class="me-1" data-feather="arrow-left"></i>
                            Back to Users List
                        </a>
                        <a class="btn btn-sm btn-primary" href="{{ route('admin.users.edit', $user->id) }}">
                            <i class="me-1" data-feather="edit"></i>
                            Edit User
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main page content-->
    <div class="container-xl px-4 mt-4">
        <div class="row">
            <div class="col-xl-4">
                <!-- Profile picture card-->
                <div class="card mb-4 mb-xl-0">
                    <div class="card-header">Profile Picture</div>
                    <div class="card-body text-center">
                        <!-- Profile picture image-->
                        <img class="img-account-profile rounded-circle mb-2" src="{{ asset('assets/img/demo/user-placeholder.svg') }}" alt="{{ $user->name }}" />
                        <!-- Profile picture help block-->
                        <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                    </div>
                </div>
            </div>

            <div class="col-xl-8">
                <!-- Account details card-->
                <div class="card mb-4">
                    <div class="card-header">User Details</div>
                    <div class="card-body">
                        <!-- Displaying User Data -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="small mb-1">Name</label>
                                <p class="form-control-static">{{ $user->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="small mb-1">Email</label>
                                <p class="form-control-static">{{ $user->email }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="small mb-1">Phone</label>
                                <p class="form-control-static">{{ $user->phone }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="small mb-1">Session</label>
                                <p class="form-control-static">{{ $user->session }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="small mb-1">Department</label>
                                <p class="form-control-static">{{ $user->department }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="small mb-1">Gender</label>
                                <p class="form-control-static">{{ ucfirst($user->gender) }}</p>
                            </div>
                        </div>

                        <!-- Additional Fields -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="small mb-1">Blood Group</label>
                                <p class="form-control-static">{{ $user->blood_group }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="small mb-1">Current Address</label>
                                <p class="form-control-static">{{ $user->current_address }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="small mb-1">Skills</label>
                                <p class="form-control-static">{{ $user->skills }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="small mb-1">Transaction ID</label>
                                <p class="form-control-static">{{ $user->transaction_id }}</p>
                            </div>
                        </div>

                        <!-- Add more fields as needed -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
