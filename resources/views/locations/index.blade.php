@extends('layouts.app')
@section('content')
<div class="container">
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <h2>Locations</h2>
    <a href="{{ route('locations.create') }}" class="btn btn-primary">Add Location</a>
    <table class="table mt-3">
        <thead><tr><th>Name</th><th>Actions</th></tr></thead>
        <tbody>
        @foreach($locations as $location)
            <tr>
                <td>{{ $location->name }}</td>
                <td>
                    <a href="{{ route('locations.edit', $location->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('locations.destroy', $location->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection