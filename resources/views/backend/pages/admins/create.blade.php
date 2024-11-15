@extends('backend.layouts.master')

@section('title')
Admin Create - Admin Panel
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
                            <div class="page-header-icon"><i data-feather="user"></i></div>
                            Create New Admin
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

    <div class="container-xl px-4 mt-4">
        <!-- First Segment: Assign Role to Existing User -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card mb-4">
                    <div class="card-header">Assign Role to Existing User</div>
                    @error('email')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="card-body">
                        <form action="{{ route('admin.admins.assignRole') }}" method="POST">
                            @csrf
                            <!-- User Type Filter -->
                            <div class="form-group">
                                <label for="usertype" class="small mb-1">Filter Users by Type</label>
                                <select name="usertype" id="usertype" class="form-control">
                                    <option value="user">User</option>
                                    <option value="volunteer">Volunteer</option>
                                    <option value="executive">Executive</option>
                                </select>
                            </div>

                            <!-- User Search and Select -->
                            <div class="form-group mt-3">
                                <label for="user_id" class="small mb-1">Search and Select User</label>
                                <select name="user_id" id="user_id" class="form-control select2" required></select>
                            </div>

                            <!-- Assign Role -->
                            <div class="form-group mt-3">
                                <label for="existing_roles" class="small mb-1">Assign Roles</label>
                                <select name="roles[]" id="existing_roles" class="form-control select2" multiple required>
                                    @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Assign Role</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Second Segment: Create New Admin -->
        <div class="row">
            <div class="col-xl-4">
                <!-- Profile picture card-->
                <div class="card mb-4 mb-xl-0">
                    <div class="card-header">Profile Picture</div>
                    <div class="card-body text-center">
                        <img class="img-account-profile rounded-circle mb-2" src="{{ asset('assets/img/demo/user-placeholder.svg') }}" alt="" />
                        <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                        <button class="btn btn-primary" type="button">Upload new image</button>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <!-- Admin Details-->
                <div class="card mb-4">
                    <div class="card-header">Admin Details</div>
                    <div class="card-body">
                        <form action="{{ route('admin.admins.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="name" class="small mb-1">Name</label>
                                <input type="text" name="name" class="form-control" id="name" placeholder="Enter name" required>
                            </div>

                            <div class="form-group">
                                <label for="username" class="small mb-1">Username</label>
                                <input type="text" name="username" class="form-control" id="username" placeholder="Enter username" required>
                            </div>

                            <div class="form-group">
                                <label for="email" class="small mb-1">Email address</label>
                                <input type="email" name="email" class="form-control" id="email" placeholder="Enter email" required>
                            </div>

                            <div class="form-group">
                                <label for="password" class="small mb-1">Password</label>
                                <input type="password" name="password" class="form-control" id="password" placeholder="Enter password" required>
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation" class="small mb-1">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Confirm password" required>
                            </div>

                            <div class="form-group mt-3">
                                <label for="roles" class="small mb-1">Assign Roles</label>
                                <select name="roles[]" id="roles" class="form-control select2" multiple>
                                    @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();

        // Load users by type
        $('#usertype').on('change', function() {
            let userType = $(this).val();
            $('#user_id').html('');
            if (userType !== '') {
                $.ajax({
                    url: "{{ route('admin.getUsersByType') }}",
                    type: "GET",
                    data: {
                        usertype: userType
                    },
                    success: function(response) {
                        $('#user_id').append('<option value="">Select User</option>');
                        response.forEach(function(user) {
                            $('#user_id').append(`<option value="${user.id}">${user.name}</option>`);
                        });
                    }
                });
            }
        });
    });
</script>
@endpush