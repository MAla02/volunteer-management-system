@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Volunteer</h2>

    <form action="{{ route('volunteers.update', $volunteer->id) }}" method="POST">
    @csrf
    @method('PUT')
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name', $volunteer->name) }}" class="form-control" required>

        </div>
        <div class="mb-3">
            <label>Email</label>
<input type="email" name="email" value="{{ old('email', $volunteer->email) }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Phone</label>
<input type="text" name="phone" value="{{ old('phone', $volunteer->phone) }}" class="form-control" required>
        </div>
<button type="submit" class="btn btn-success">Update</button>
    </form>
</div>
@endsection

