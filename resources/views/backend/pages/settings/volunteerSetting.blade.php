@extends('backend.layouts.master')

@section('admin-content')
<div class="container">
<div class="row justify-content-center">
    <div class="col-12 col-lg-10 col-xl-8 mx-auto">
        <h2 class="h3 mb-4 py-4 page-title">Settings</h2>
        <div class="my-4">
            <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Application</a>
                </li>
            </ul>

            <div class="list-group mb-5 shadow">
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col">
                            <strong class="mb-0">Volunteer Application Status</strong>
                            <p class="text-muted mb-0">Turn on or off to control applying for volunteer</p>
                        </div>
                        <div class="col-auto">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="volunteerStatusSwitch"
                                       @if($setting->volunteer_application_enabled) checked @endif />
                                <span class="custom-control-label"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>

<script>
    document.getElementById('volunteerStatusSwitch').addEventListener('change', function() {
        var status = this.checked ? 1 : 0;
        // Send AJAX request to update the status
        $.ajax({
            url: '{{ route('admin.toggleVolunteerStatus') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                volunteer_application_enabled: status
            },
            success: function(response) {
                if (response.success) {
                    alert('Status updated: ' + (status ? 'On' : 'Off'));
                }
            },
            error: function(xhr, status, error) {
                alert('Something went wrong!');
            }
        });
    });
</script>

@endsection
