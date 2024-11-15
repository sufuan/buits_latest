
 @extends('backend.layouts.master')

@section('admin-content')
<div class="container mt-5">
    <h2>Bulk Import Users</h2>

    {{-- Display success message --}}
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    {{-- Display error message --}}
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    {{-- Display validation errors --}}
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Define the departments array directly in Blade --}}
    @php
    $departments = [
        'Marketing', 'Law', 'Mathematics', 'Physics', 'History & Civilization',
        'Soil & Environmental Sciences', 'Economics', 'Geology & Mining',
        'Management Studies', 'Statistics', 'Chemistry', 'Coastal Studies and Disaster Management',
        'Accounting & Information Systems', 'Computer Science and Engineering', 'Sociology',
        'Botany', 'Public Administration', 'Philosophy', 'Political Science',
        'Biochemistry and Biotechnology', 'Finance and Banking',
        'Mass Communication and Journalism', 'English', 'Bangla'
    ];
    @endphp

    {{-- Form for file upload --}}
    <form action="{{ route('admin.users.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="import_file" class="form-label">Select Excel File</label>
            <input type="file" class="form-control" id="import_file" name="import_file" required>
        </div>



        <button type="submit" class="btn btn-primary">Import</button>
    </form>

    {{-- Sample format download link --}}
    <div class="mt-3">
        <a href="{{ asset('downloads/users_sample.xlsx') }}"
            class="btn btn-info"
            data-toggle="tooltip"
            title="Click to download a sample Excel file format to fill in your data."
            id="downloadSampleButton">
            Download Sample Excel File
        </a>
    </div>

    {{-- Display the list of departments in two rows --}}
    <div class="mb-3 mt-4">
        <h4>Instructions</h4>
        <h5>Available Departments <span class="text-muted" style="font-size: 0.85rem;">(Case-sensitive)</span></h5>
        <div class="row">
            <div class="col-md-6">
                <ul class="list-unstyled small">
                    @foreach(array_slice($departments, 0, ceil(count($departments) / 2)) as $department)
                    <li>{{ $department }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-6">
                <ul class="list-unstyled small">
                    @foreach(array_slice($departments, ceil(count($departments) / 2)) as $department)
                    <li>{{ $department }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    {{-- Display required fields --}}
    <div class="mb-3 mt-4">
        <h5>Required Fields</h5>
        <ul class="small">
            <li><strong>Name:</strong> Required, max 255 characters</li>
            <li><strong>Email:</strong> Required, must be unique, valid email</li>
            <li><strong>Password:</strong> Required, min 6 characters</li>
            <li><strong>Phone:</strong> Required, max 15 characters</li>
            <li><strong>User Type:</strong> Required, must be either 'user' or 'volunteer'</li>
            <li><strong>Date of Birth:</strong> Required, format YYYY-MM-DD</li>
            <li><strong>Gender:</strong> Required, must be either 'male', 'female', or 'other'</li>
            <li><strong>Session:</strong> Required, max 20 characters</li>
            <li><strong>Department:</strong> Required, max 100 characters</li>
            <li><strong>Blood Group:</strong> Optional, max 3 characters</li>
            <li><strong>Class Roll:</strong> Required, string</li>
            <li><strong>Father's Name:</strong> Required, max 255 characters</li>
            <li><strong>Mother's Name:</strong> Required, max 255 characters</li>
            <li><strong>Current Address:</strong> Required, max 255 characters</li>
            <li><strong>Permanent Address:</strong> Required, max 255 characters</li>
            <li><strong>Transaction ID:</strong> Required, max 100 characters</li>
            <li><strong>Custom Form:</strong> Optional, max 500 characters</li>
            <li><strong>Approval Status:</strong> Required, boolean - 0 or 1 </li>
        </ul>
    </div>
</div>
@endsection
