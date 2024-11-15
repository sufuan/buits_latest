@extends('backend.layouts.master')

@section('admin-content')
<div class="d-flex justify-content-end align-items-center">
    <div id="toolbar" class="d-flex align-items-center gap-2">
        <!-- Import Button with Tooltip -->
        <button id="importButton" class="btn btn-secondary ml-2" title="Import Users">
            <i class="fa fa-download"></i>
        </button>

        <!-- Download Button for Export -->
        <a href="{{ route('admin.users.export') }}" class="btn btn-secondary ml-2" title="Export Users">
            <i class="fa fa-upload"></i>
        </a>
    </div>
</div>

<div class="">
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
        data-side-pagination="client"  
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
    var $table = $('#table');
    var selections = [];

    function getIdSelections() {
        return $.map($table.bootstrapTable('getSelections'), function(row) {
            return row.id;
        });
    }

    function responseHandler(res) {
        $.each(res.rows, function(i, row) {
            row.state = $.inArray(row.id, selections) !== -1;
        });
        return res;
    }

    function detailFormatter(index, row) {
        var html = [];
        $.each(row, function(key, value) {
            html.push('<p><b>' + key + ':</b> ' + value + '</p>');
        });
        return html.join('');
    }

    function operateFormatter(value, row, index) {
        return [
            '<a class="edit" href="/admin/users/' + row.id + '/edit" title="Edit">',
            '<i class="fa fa-edit"></i>',
            '</a>  ',
            '<a class="remove" href="javascript:void(0)" title="Remove">',
            '<i class="fa fa-trash"></i>',
            '</a>'
        ].join('');
    }

    window.operateEvents = {
        'click .remove': function(e, value, row, index) {
            if (confirm('Are you sure you want to delete this user?')) {
                $.ajax({
                    url: '/admin/users/' + row.id,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert('User deleted successfully.');
                        $('#table').bootstrapTable('refresh');
                    },
                    error: function(xhr, status, error) {
                        console.log('Error deleting user:', xhr.responseText);
                    }
                });
            }
        }
    };

    function initTable() {
        $table.bootstrapTable({
            height: 580,
            locale: 'en-US',
            pagination: true,               // Enable client-side pagination
            pageSize: 10,                   // Default page size
            pageList: [10, 25, 50, 100, 'all'], // Available page sizes
            sidePagination: 'client',       // This tells the table to handle pagination client-side
            url: "{{ url('admin/userlistjson') }}", // Not needed for client-side pagination but can be used to pre-load data
            columns: [
                { 
                    field: 'member_id', 
                    title: 'Member Id', 
                    sortable: true, 
                    align: 'center',
                    formatter: function(value, row, index) {
                        return row.deleted_at ? '<span class="text-danger">User has been deleted</span>' : value;
                    }
                },
                { 
                    field: 'name', 
                    title: 'Name', 
                    sortable: true, 
                    align: 'center',
                    formatter: function(value, row, index) {
                        if (row.deleted_at) {
                            return '<span class="text-danger">User has been deleted</span>';
                        }
                        var url = "{{ url('admin/users') }}/" + row.id;
                        return '<a href="' + url + '" title="View User">' + value + '</a>';
                    }
                },
                { 
                    field: 'email', 
                    title: 'Email', 
                    sortable: true, 
                    align: 'center',
                    formatter: function(value, row, index) {
                        return row.deleted_at ? '<span class="text-danger">User has been deleted</span>' : value;
                    }
                },
                { 
                    field: 'phone', 
                    title: 'Phone', 
                    sortable: true, 
                    align: 'center',
                    formatter: function(value, row, index) {
                        return row.deleted_at ? '<span class="text-danger">User has been deleted</span>' : value;
                    }
                },
                { 
                    field: 'usertype', 
                    title: 'User Type', 
                    sortable: true, 
                    align: 'center',
                    formatter: function(value, row, index) {
                        return row.deleted_at ? '<span class="text-danger">User has been deleted</span>' : value;
                    }
                },
                { 
                    field: 'session', 
                    title: 'Session', 
                    sortable: true, 
                    align: 'center',
                    formatter: function(value, row, index) {
                        return row.deleted_at ? '<span class="text-danger">User has been deleted</span>' : value;
                    }
                },
                { 
                    field: 'department', 
                    title: 'Department', 
                    sortable: true, 
                    align: 'center',
                    formatter: function(value, row, index) {
                        return row.deleted_at ? '<span class="text-danger">User has been deleted</span>' : value;
                    }
                },
                { 
                    field: 'transaction_id', 
                    title: 'Transaction ID', 
                    sortable: true, 
                    align: 'center',
                    formatter: function(value, row, index) {
                        return row.deleted_at ? '<span class="text-danger">User has been deleted</span>' : value;
                    }
                },
                { 
                    field: 'to_account', 
                    title: 'To Account', 
                    sortable: true, 
                    align: 'center',
                    formatter: function(value, row, index) {
                        return row.deleted_at ? '<span class="text-danger">User has been deleted</span>' : value;
                    }
                },
                { 
                    field: 'gender', 
                    title: 'Gender', 
                    sortable: true, 
                    align: 'center',
                    formatter: function(value, row, index) {
                        return row.deleted_at ? '<span class="text-danger">User has been deleted</span>' : value;
                    }
                },
                { 
                    field: 'blood_group', 
                    title: 'Blood Group', 
                    sortable: true, 
                    align: 'center',
                    formatter: function(value, row, index) {
                        return row.deleted_at ? '<span class="text-danger">User has been deleted</span>' : value;
                    }
                },
                { 
                    field: 'current_address', 
                    title: 'Current Address', 
                    sortable: true, 
                    align: 'center',
                    formatter: function(value, row, index) {
                        return row.deleted_at ? '<span class="text-danger">User has been deleted</span>' : value;
                    }
                },
                { 
                    field: 'skills', 
                    title: 'Skills', 
                    sortable: true, 
                    align: 'center',
                    formatter: function(value, row, index) {
                        return row.deleted_at ? '<span class="text-danger">User has been deleted</span>' : value;
                    }
                }
            ]
        });
    }

    $(function() {
        initTable();

        // Handle import button click
        $('#importButton').on('click', function() {
            window.location.href = "{{ route('admin.users.import.view') }}";
        });
    });
</script>
@endpush
