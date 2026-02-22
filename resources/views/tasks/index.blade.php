@extends('layouts.app')
@section('content')
<div class="container">
            @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <h2>Tasks</h2>
    <a href="{{ route('tasks.create') }}" class="btn btn-primary">Add Task</a>
    <table class="table mt-3">
        <thead><tr><th>Name</th><th>Actions</th></tr></thead>
        <tbody>
        @foreach($tasks as $task)
            <tr>
                <td>{{ $task->name }}</td>
                <td>
                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline">
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