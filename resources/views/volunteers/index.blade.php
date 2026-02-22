@extends('layouts.app')

@section('content')
<div class="container">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h2>Volunteers List</h2>
    <a href="{{ route('volunteers.create') }}" class="btn btn-primary mb-3">Add New Volunteer</a>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($volunteers as $volunteer)
                <tr>
                    <td>{{ $volunteer->name }}</td>
                    <td>{{ $volunteer->email }}</td>
                    <td>{{ $volunteer->phone }}</td>
                    <td>
                        <a href="{{ route('volunteers.edit', $volunteer->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('volunteers.destroy', $volunteer->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection


