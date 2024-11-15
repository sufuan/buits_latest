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



















@extends('backend.layouts.master')

@section('admin-content')
<div>
    <table
        id="table"
        data-toolbar="#toolbar"
        data-search="true"
        data-show-refresh="true"
        data-show-toggle="true"
        data-show-fullscreen="true"
        data-show-columns="true"
        data-show-columns-toggle-all="true"
        data-detail-view="true"
        data-show-export="true"
        data-click-to-select="true"
        data-detail-formatter="detailFormatter"
        data-minimum-count-columns="2"
        data-show-pagination-switch="true"
        data-pagination="true"
        data-id-field="id"
        data-page-list="[10, 25, 50, 100, all]"
        data-show-footer="true"
        data-side-pagination="server"
        data-url="{{ url('admin/userlistjson') }}"
        data-response-handler="responseHandler">
    </table>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.0/dist/bootstrap-table.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.29.0/tableExport.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.29.0/libs/jsPDF/jspdf.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.0/dist/extensions/export/bootstrap-table-export.min.js"></script>

<script>
    var $table = $('#table')
    var selections = []

    function getIdSelections() {
        return $.map($table.bootstrapTable('getSelections'), function(row) {
            return row.id
        })
    }

    function responseHandler(res) {
        $.each(res.rows, function(i, row) {
            row.state = $.inArray(row.id, selections) !== -1
        })
        return res
    }

    function detailFormatter(index, row) {
        var html = []
        $.each(row, function(key, value) {
            html.push('<p><b>' + key + ':</b> ' + value + '</p>')
        })
        return html.join('')
    }

    function operateFormatter(value, row, index) {
        return [
            '<a class="edit" href="/admin/users/' + row.id + '/edit" title="Edit">',
            '<i class="fa fa-edit"></i>',
            '</a>  ',
            '<a class="remove" href="javascript:void(0)" title="Remove">',
            '<i class="fa fa-trash"></i>',
            '</a>'
        ].join('')
    }

    window.operateEvents = {
        'click .remove': function(e, value, row, index) {
            if (confirm('Are you sure you want to delete this user?')) {
                $.ajax({
                    url: '/admin/users/' + row.id, // This URL should match your route
                    type: 'DELETE', // Use DELETE method
                    data: {
                        _token: '{{ csrf_token() }}' // Include CSRF token
                    },
                    success: function(response) {
                        alert('User deleted successfully.');
                        $('#table').bootstrapTable('refresh'); // Refresh the table
                    },
                    error: function(xhr, status, error) {
                        console.log('Error deleting user:', xhr.responseText);
                    }
                });
            }
        }
    }

    function initTable() {
        $table.bootstrapTable({
            height: 550,
            locale: 'en-US', // Set the locale
            columns: [{
                    field: 'name',
                    title: 'Name',
                    sortable: true,
                    align: 'center'
                },
                {
                    field: 'email',
                    title: 'Email',
                    sortable: true,
                    align: 'center'
                },
                {
                    field: 'operate',
                    title: 'Actions',
                    align: 'center',
                    clickToSelect: false,
                    events: window.operateEvents,
                    formatter: operateFormatter
                }
            ]
        });
    }

    $(function() {
        initTable()
    });
</script>
@endpush