@extends('backend.layouts.master')

@section('admin-content')

<div class="content container-fluid">
    <div class="card mb-3">
        <div class="card-header">
            <h5>Edit Promotional Banner</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('promotional-banner.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3 lang_form" id="default-form">
                    <div class="col-sm-6">
                        <label class="form-label">Title</label>
                        <input type="text" maxlength="20" name="title" class="form-control" value="{{ $banner->title }}" placeholder="Enter title here...">
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label">Sub Title</label>
                        <input type="text" maxlength="80" name="sub_title" class="form-control" value="{{ $banner->sub_title }}" placeholder="Enter sub title here...">
                    </div>
                </div>

                <div class="row g-3 mt-3">
                    <div class="col-sm-6">
                        <label class="form-label d-block mb-2">Banner <span class="text--primary">(size: 3:1)</span></label>
                        <label class="upload-img-3 m-0 d-block">
                            <div class="img">
                                <img 
                                    id="bannerPreview" 
                                    src="{{ asset('storage/' . $banner->image) }}" 
                                    onerror='this.src="{{ asset("assets/landing/img/upload-4.png") }}"' 
                                    class="vertical-img mw-100 vertical" 
                                    alt="">
                            </div>
                            <input type="file" name="image" id="imageInput" accept="image/*" hidden>
                            <button type="button" class="btn btn--primary mt-2" onclick="document.getElementById('imageInput').click();">Upload New Image</button>
                        </label>
                    </div>
                </div>

                <div class="btn--container justify-content-end mt-3">
                    <a href="{{ route('promotional-section') }}" class="btn btn--secondary">Cancel</a>
                    <button type="submit" class="btn btn--primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

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

@endsection
