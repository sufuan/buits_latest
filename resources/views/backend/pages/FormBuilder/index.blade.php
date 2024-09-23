@extends('backend.layouts.master')

@section('title')
Dashboard Page - Admin Panel
@endsection


@section('admin-content')
<div class="card">
    <div class="card-body">
    @if (Auth::guard('admin')->user()->can('forms.create'))  
    <a href="{{ URL('admin/formbuilder') }}" class="btn btn-success">{{__('Create')}}</a>
     @endif
    <table class="table">
            <thead>
                <th>{{__('Name')}}</th>
                <th>{{__('Action')}}</th>
            </thead>
            <tbody>
                @foreach ($forms as $form)
                <tr>
                    <td>{{ $form->name }}</td>
                    <td>
                    @if (Auth::guard('admin')->user()->can('forms.edit'))  
                    <a href="{{ URL('admin/edit-form-builder', $form->id) }}" class="btn btn-primary">{{__('Edit')}}</a>
                    @endif

                    <a href="{{ URL('admin/read-form-builder', $form->id) }}" class="btn btn-primary">{{__('Show')}}</a>

                    @if (Auth::guard('admin')->user()->can('forms.edit'))  
                        <form method="POST" action="{{ URL('admin/form-delete', $form->id) }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">{{__('Delete')}}</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection