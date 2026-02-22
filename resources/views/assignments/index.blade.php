@extends('layouts.app')
@section('content')
<div class="container">
    <h2>All Assignments</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ route('assignments.create') }}" class="btn btn-primary mb-3">Assign New Volunteer</a>
    <table class="table">
        <thead><tr><th>Volunteer</th><th>Location</th><th>Task</th></tr></thead>
        <tbody>
        @foreach($assignments as $assignment)
            <tr>
                <td>{{ $assignment->volunteer->name }}</td>
                <td>{{ $assignment->location->name }}</td>
                <td>{{ $assignment->task->name }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection