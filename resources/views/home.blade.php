@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Dashboard</h2>

    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
             <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            {{ session('status') }}
        </div>
    @endif

     <div class="list-group list-group-flush">
        <a href="{{ route('volunteers.index') }}" class="list-group-item list-group-item-action">Manage Volunteers</a>
        <a href="{{ route('locations.index') }}" class="list-group-item list-group-item-action">Manage Work Locations</a>
        <a href="{{ route('tasks.index') }}" class="list-group-item list-group-item-action">Manage Tasks</a>
        <a href="{{ route('assignments.index') }}" class="list-group-item list-group-item-action">Assign Volunteers</a>
    </div>
</div>
@endsection

