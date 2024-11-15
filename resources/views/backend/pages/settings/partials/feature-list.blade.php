@extends('backend.layouts.master')

@section('admin-content')

<div class="content container-fluid">
   
    <div class="mb-4 mt-2">
        <div class="js-nav-scroller hs-nav-scroller-horizontal">
            @include('backend.pages.settings.partials.admin-landing-page-links')
        </div>
    </div>
   
    <div class="tab-content">
        <h1>helllo </h1>
    </div>
</div>

@endsection



@push('scripts')

@endpush
