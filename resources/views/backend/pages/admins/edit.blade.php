@extends('backend.layouts.master')

@section('title')
Admin Edit - Admin Panel
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
                            Edit Admin - {{ $admin->name }}
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" href="{{ route('admin.admins.index') }}">
                            <i class="me-1" data-feather="arrow-left"></i>
                            Back to Admins List
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
                        <form action="{{ route('admin.admins.update', $admin->id) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <!-- Form Row-->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (name)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="name">Admin Name</label>
                                    <input class="form-control" id="name" type="text" name="name" placeholder="Enter Name" value="{{ $admin->name }}" required />
                                </div>
                                <!-- Form Group (username)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="username">Admin Username</label>
                                    <input class="form-control" id="username" type="text" name="username" placeholder="Enter Username" value="{{ $admin->username }}" required />
                                </div>
                            </div>
                            <!-- Form Group (email)-->
                            <div class="mb-3">
                                <label class="small mb-1" for="email">Admin Email</label>
                                <input class="form-control" id="email" type="email" name="email" placeholder="Enter Email" value="{{ $admin->email }}" required />
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
                            <!-- Form Group (roles)-->
                            <div class="form-group">
                                <label for="roles" class="small mb-1">Assign Roles</label>
                                <select name="roles[]" id="roles" class="form-control select2" multiple>
                                    @foreach ($roles as $role)
                                    <option value="{{ $role->name }}" {{ $admin->hasRole($role->name) ? 'selected' : '' }}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Save Admin</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection