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
                            New User Approval Requests
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main page content -->
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
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                               5
                            </td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                            <td>
                                <!-- Approve Switch -->
                                <div class="form-check form-switch">
                                    <input class="form-check-input approve-switch" type="checkbox" data-id="{{ $user->id }}">
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        $('.approve-switch').on('change', function() {
    var userId = $(this).data('id');  // Retrieve the user's ID
    $.ajax({
        url: `{{ route("admin.users.approve", ":userId") }}`.replace(':userId', userId),
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
        },
        success: function(response) {
            alert('User approved successfully!');
            location.reload();  // Reload the page to reflect changes
        },
        error: function(xhr) {
            alert('An error occurred while approving the user.');
        }
    });
});

    });
</script>
@endsection
