@extends('backend.layouts.master')

@section('admin-content')

<div class="content container-fluid">
    <div class="mb-4 mt-2">
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
                                    <button type="button" class="btn btn--primary mt-2" onclick="document.getElementById('imageInput').click();">Upload Image</button>
                                </label>
                            </div>
                        </div>
                        <div class="btn--container justify-content-end mt-3">
                            <button type="reset" class="btn btn--reset">Reset</button>
                            <button type="submit" class="btn btn--primary mb-2">Add</button>
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
                                            <input type="checkbox" class="toggle-switch-input" onclick="toogleStatusModal(event,'status-{{$banner->id}}','promotional-on.png','promotional-off.png','Turn ON Promotional Banner Section','Turn OFF Promotional Banner Section',`<p>Promotional banner will be enabled. You will be able to see promotional activity</p>`,`<p>Promotional banner will be disabled. You will be unable to see promotional activity</p>`)" id="status-{{$banner->id}}" {{$banner->status ? 'checked' : ''}}>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                        <form action="{{ route('promotional-banner.status', [$banner->id, $banner->status ? 0 : 1]) }}" method="get" id="status-{{$banner->id}}_form"></form>
                                    </td>
                                    <td>
                                        <div class="btn--container justify-content-center">
                                            <a class="btn action-btn btn--primary btn-outline-primary" href="{{ route('promotional-banner.edit', [$banner['id']]) }}">
                                                <i class="tio-edit"></i>
                                            </a>
                                            <a class="btn action-btn btn--danger btn-outline-danger" href="javascript:" onclick="form_alert('banner-{{$banner['id']}}','Want to delete this banner?')" title="Delete Banner"><i class="tio-delete-outlined"></i></a>
                                            <form action="{{ route('promotional-banner.delete', [$banner['id']]) }}" method="post" id="banner-{{$banner['id']}}">
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
                <div class="empty--data">
                    <img src="{{ asset('/assets/admin/svg/illustrations/sorry.svg') }}" alt="public">
                    <h5>No data found</h5>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .upload-img-3 img.vertical-img {
        object-fit: cover;
        aspect-ratio: 756 / 189; /* Adjusts the height/width ratio */
        width: 100%; /* Ensures it fills the parent container */
        height: auto; /* Maintains the aspect ratio */
    }
</style>
@endpush

@push('scripts')
<script>
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
