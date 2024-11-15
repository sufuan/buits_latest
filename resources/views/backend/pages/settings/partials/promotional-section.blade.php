@extends('backend.layouts.master')

@section('admin-content')

<div class="content container-fluid">
    <div class="mb-4 mt-4">
        <div class="js-nav-scroller hs-nav-scroller-horizontal">
            @include('backend.pages.settings.partials.admin-landing-page-links')
        </div>
    </div>

    <div class="tab-content">
        <div class="tab-pane fade show active">
            <form action="{{ route('promotional-banner.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row g-3 lang_form" id="default-form">
                            <div class="col-sm-6">
                                <label class="form-label">Title</label>
                                <input type="text" maxlength="20" name="title[]" class="form-control" placeholder="Enter title here...">
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">Sub Title</label>
                                <input type="text" maxlength="80" name="sub_title[]" class="form-control" placeholder="Enter sub title here...">
                            </div>
                        </div>
                        <input type="hidden" name="lang[]" value="default">

                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label class="form-label d-block mb-2">Banner <span class="text--primary">(size: 3:1)</span></label>
                                <label class="upload-img-3 m-0 d-block">
                                    <div class="img">
                                        <img
                                            id="bannerPreview"
                                            src=""
                                            onerror='this.src="{{ asset("assets/landing/img/upload-4.png") }}"'
                                            class="vertical-img mw-100 vertical"
                                            alt="">
                                    </div>
                                    <input type="file" name="image" id="imageInput" accept="image/*" hidden>
                                </label>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <button type="reset" class="btn btn-danger me-2">Reset</button>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>

                    </div>
                </div>
            </form>

            @php($banners = \App\Models\AdminPromotionalBanner::all())
            <div class="card">
                <div class="card-header py-2">
                    <h5 class="card-title">Promotional Banner List</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive datatable-custom">
                        <table id="columnSearchDatatable" class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table" data-hs-datatables-options='{"order": [], "orderCellsTop": true, "paging":false}'>
                            <thead class="thead-light">
                                <tr>
                                    <th class="border-0">SL</th>
                                    <th class="border-0">Title</th>
                                    <th class="border-0">Sub Title</th>
                                    <th class="border-0">Image</th>
                                    <th class="border-0">Status</th>
                                    <th class="text-center border-0">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($banners as $key => $banner)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <div class="text--title">{{ $banner->title }}</div>
                                    </td>
                                    <td><span class="d-block font-size-sm text-body">{{ $banner->sub_title }}</span></td>
                                    <td>
                                        <img
                                            src="{{ asset('storage/' . $banner->image) }}"
                                            onerror="this.src='{{ asset("assets/landing/img/upload-3.png") }}'"
                                            class="__size-105"
                                            alt=""
                                            style="width: 105px; height: 40px; object-fit: cover; border-radius: 5px; border: 1px solid #ccc; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                                    </td>
                                    <td>
                                        <label class="toggle-switch toggle-switch-sm">
                                            <input type="checkbox" class="toggle-switch-input" onclick="toggleStatusModal(event, 'status-{{$banner->id}}', 'Activate Banner', 'Deactivate Banner', 'Are you sure you want to activate this banner?', 'Are you sure you want to deactivate this banner?')" {{$banner->status ? 'checked' : ''}}>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                        <form action="{{ route('promotional-banner.status', [$banner->id, $banner->status ? 0 : 1]) }}" method="get" id="status-{{$banner->id}}_form"></form>
                                    </td>
                                    <td>
                                        <div class="btn--container justify-content-center">
                                            <a class="btn action-btn btn--primary btn-outline-primary" href="{{ route('promotional-banner.edit', $banner->id) }}" title="Edit Banner">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a class="btn action-btn btn--danger btn-outline-danger" href="javascript:" onclick="toggleDeleteModal('banner-{{$banner->id}}')" title="Delete Banner">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                            <form action="{{ route('promotional-banner.delete', $banner->id) }}" method="post" id="banner-{{$banner->id}}">
                                                @csrf @method('delete')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @if(count($banners) === 0)
                <div class="empty--data text-center">
                    <img src="{{ asset('/assets/img/illustrations/sorry.svg') }}" width="150" height="130" alt="public">
                    <h5>No data found</h5>
                </div>
                @endif
            </div>

            <!-- Modal for status confirmation -->
            <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="statusModalLabel"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="statusModalBody"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" id="confirmToggleStatus">Confirm</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal for delete confirmation -->
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Delete Banner</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete this banner?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let currentStatusFormId;
    let currentDeleteFormId;

    function toggleStatusModal(event, formId, titleOn, titleOff, bodyOn, bodyOff) {
        currentStatusFormId = formId; // Store the form ID to toggle later

        // Set modal title and body based on current status
        const isChecked = event.target.checked;
        document.getElementById('statusModalLabel').innerText = isChecked ? titleOn : titleOff;
        document.getElementById('statusModalBody').innerHTML = isChecked ? bodyOn : bodyOff;

        // Show the modal
        var myModal = new bootstrap.Modal(document.getElementById('statusModal'));
        myModal.show();

        // Attach event to the confirm button
        document.getElementById('confirmToggleStatus').onclick = function() {
            // Submit the form
            document.getElementById(currentStatusFormId + '_form').submit();
            myModal.hide();
        };
    }

    function toggleDeleteModal(formId) {
        currentDeleteFormId = formId; // Store the form ID to delete later

        // Show the delete modal
        var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();

        // Attach event to the confirm button
        document.getElementById('confirmDelete').onclick = function() {
            // Submit the form for deletion
            document.getElementById(currentDeleteFormId).submit();
            deleteModal.hide();
        };
    }

    // Function to preview the image
    document.getElementById('imageInput').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('bannerPreview').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush