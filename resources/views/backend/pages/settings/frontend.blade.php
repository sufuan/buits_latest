@extends('backend.layouts.master')

@section('admin-content')
<div class="content container-fluid">
    <div class="mb-4 mt-2">
        <div class="js-nav-scroller hs-nav-scroller-horizontal">
            @include('backend.pages.settings.partials.admin-landing-page-links')
        </div>
    </div>

    <div class="tab-content">
        <div class="card">
            <div class="card-header">
                <h4>Frontend Settings</h4>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <form action="{{ route('admin.settings.frontend.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Business Name -->
                    <div class="form-group">
                        <label for="business_name">Business Name</label>
                        <input type="text" name="business_name" class="form-control" value="{{ $frontendSettings->business_name ?? '' }}">
                    </div>

                    <!-- Logo -->
                    <div class="form-group">
                        <label for="logo">Logo</label>
                        <input type="file" name="logo" class="form-control">
                        @if($frontendSettings && $frontendSettings->logo)
                            <img src="{{ Storage::url($frontendSettings->logo) }}" alt="Logo" width="100">
                        @endif
                    </div>

                    <!-- Phone -->
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ $frontendSettings->phone ?? '' }}">
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $frontendSettings->email ?? '' }}">
                    </div>

                    <!-- Address -->
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea name="address" class="form-control">{{ $frontendSettings->address ?? '' }}</textarea>
                    </div>

                    <!-- Footer Text -->
                    <div class="form-group">
                        <label for="footer_text">Footer Text</label>
                        <textarea name="footer_text" class="form-control">{{ $frontendSettings->footer_text ?? '' }}</textarea>
                    </div>

                    <!-- Social Media Links -->
                    <div class="form-group">
                        <label for="facebook">Facebook</label>
                        <input type="url" name="facebook" class="form-control" value="{{ $frontendSettings->facebook ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label for="instagram">Instagram</label>
                        <input type="url" name="instagram" class="form-control" value="{{ $frontendSettings->instagram ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label for="twitter">Twitter</label>
                        <input type="url" name="twitter" class="form-control" value="{{ $frontendSettings->twitter ?? '' }}">
                    </div>

                    <!-- About Us Description -->
                    <div class="form-group">
                        <label for="about_us_description">About Us Description</label>
                        <textarea name="about_us_description" class="form-control" rows="5">{{ $frontendSettings->about_us_description ?? '' }}</textarea>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Save Settings</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@endpush
