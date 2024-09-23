@extends('backend.layouts.master')

@section('admin-content')

<main>
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="user"></i></div>
                            Users List
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        @if (Auth::guard('admin')->user()->can('user.create'))
                        <a class="btn btn-sm btn-light text-primary" href="{{route('admin.users.create')}}">
                            <i class="me-1" data-feather="user-plus"></i>
                            Add New User
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-fluid px-4">
        <div class="card">
            <div class="card-body">
                <table id="datatablesSimple" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Joined Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar me-2">
                                        <img class="avatar-img img-fluid" src="{{ asset('assets/img/illustrations/profiles/profile-1.png') }}" alt="User Avatar" />
                                    </div>
                                    {{ $user->name }}
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @foreach($user->roles as $role)
                                <span class="badge badge-info">{{ $role->name }}</span>
                                @endforeach
                            </td>

                            <td>{{ $user->created_at->format('d M Y') }}</td>
                            <td>
                                @if (Auth::guard('admin')->user()->can('user.edit'))
                                <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" href="{{ route('admin.users.edit', $user->id) }}">
                                    <i data-feather="edit"></i>
                                </a>

                                @endif
                                @if (Auth::guard('admin')->user()->can('user.delete'))


                                <a class="btn btn-datatable btn-icon btn-transparent-dark" href="{{ route('admin.users.destroy', $user->id) }}" data-confirm-delete="true"> <i data-feather="trash-2" style="width: 36px; height: 36px;"></i>
                                </a>

                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>


@endsection