@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Dashboard</h2>

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="list-group">
        <a href="{{ route('volunteers.index') }}" class="list-group-item list-group-item-action">Manage Volunteers</a>
        <a href="{{ route('locations.index') }}" class="list-group-item list-group-item-action">Manage Work Locations</a>
        <a href="{{ route('tasks.index') }}" class="list-group-item list-group-item-action">Manage Tasks</a>
        <a href="{{ route('assignments.index') }}" class="list-group-item list-group-item-action">Assign Volunteers</a>
    </div>
</div>
@endsection

