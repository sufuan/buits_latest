@extends('backend.layouts.master')


@section('admin-content')
<div class="container">
    <h1>Admin Notifications</h1>

    <ul>
        @foreach (auth()->user()->notifications as $notification)
            <li>
                {{ $notification->data['message'] }}
                <br>
                <small>{{ $notification->created_at }}</small>
            </li>
        @endforeach
    </ul>
</div>
@endsection
