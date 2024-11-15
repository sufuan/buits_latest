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
                            Roles & Permission List
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        @if (Auth::guard('admin')->user()->can('role.create'))
                        <a class="btn btn-md btn-light text-primary" href="{{route('admin.roles.create')}}">
                            <i class="me-1" data-feather="shield" style="width: 16px; height: 16px;"></i>
                            Add New Roles
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </header>
    @include('backend.layouts.partials.messages')
    <!-- Main page content-->
    <div class=" container-fluid px-4">
        <div class="card">
            <div class="card-body">
                <table id="datatablesSimple" class="display">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                                @foreach ($role->permissions as $perm)
                                <span class="badge bg-info text-dark mr-1">
                                    {{ $perm->name }}
                                </span>
                                @endforeach
                            </td>
                            <td>
                                @if(Auth::guard('admin')->user()->can('role.edit'))
                                <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" href="{{ route('admin.roles.edit', $role->id) }}"><i class="fa-solid fa-pencil-alt"></i></a>

                                @endif
                                @if(Auth::guard('admin')->user()->can('role.delete'))



                                <a class="btn btn-datatable btn-icon btn-transparent-dark" href="{{ route('admin.roles.destroy', $role->id) }}" data-confirm-delete="true"> <i data-feather="trash-2" style="width: 36px; height: 36px;"></i>
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