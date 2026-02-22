@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Edit Task</h2>
    <form method="POST" action="{{ route('tasks.update', $task->id) }}">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ $task->name }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection