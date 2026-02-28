@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="text-black fw-bold mb-0">Edit Assignment</h2>
                        <a href="{{ route('assignments.index') }}" class="btn btn-outline-secondary btn-sm" style="border-radius: 8px;">
                            Back to List
                        </a>
                    </div>

                    <form action="{{ route('assignments.update', $assignment->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold">Volunteer</label>
                            <select name="volunteer_id" class="form-select" style="border-radius: 8px;">
                                @foreach($volunteers as $volunteer)
                                    <option value="{{ $volunteer->id }}" {{ $assignment->volunteer_id == $volunteer->id ? 'selected' : '' }}>
                                        {{ $volunteer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Location</label>
                            <select name="location_id" class="form-select" style="border-radius: 8px;">
                                @foreach($locations as $location)
                                    <option value="{{ $location->id }}" {{ $assignment->location_id == $location->id ? 'selected' : '' }}>
                                        {{ $location->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Task</label>
                            <select name="task_id" class="form-select" style="border-radius: 8px;">
                                @foreach($tasks as $task)
                                    <option value="{{ $task->id }}" {{ $assignment->task_id == $task->id ? 'selected' : '' }}>
                                        {{ $task->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Status</label>
                            <select name="status" class="form-select" style="border-radius: 8px;">
                                <option value="pending" {{ $assignment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="completed" {{ $assignment->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $assignment->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success fw-bold py-2" style="border-radius: 8px;">
                                Update Assignment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection