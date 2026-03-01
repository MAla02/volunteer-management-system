@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Add Location</h2>
    <form method="POST" action="{{ route('locations.store') }}">
        @csrf
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>
@endsection