@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-header bg-white border-0 pt-4">
                    <h3 class="fw-bold text-primary mb-0">Assign Volunteer to Task</h3>
                    <p class="text-muted small">Sprint 3: Distribute Assignments (Story #5)</p>
                </div>

                <div class="card-body p-4">
                    {{-- عرض الأخطاء بشكل مرتب --}}
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 shadow-sm" style="border-radius: 10px;">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('assignments.store') }}">
                        @csrf
                        
                        {{-- اختيار المتطوع --}}
                        <div class="mb-3">
                            <label for="volunteer_id" class="form-label fw-bold">Select Volunteer</label>
                            <select name="volunteer_id" class="form-select @error('volunteer_id') is-invalid @enderror" required>
                                <option value="">-- Choose a Volunteer --</option>
                                @foreach($volunteers as $volunteer)
                                    <option value="{{ $volunteer->id }}" {{ old('volunteer_id') == $volunteer->id ? 'selected' : '' }}>
                                        {{ $volunteer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            {{-- اختيار الموقع --}}
                            <div class="col-md-6 mb-3">
                                <label for="location_id" class="form-label fw-bold">Location</label>
                                <select name="location_id" class="form-select @error('location_id') is-invalid @enderror" required>
                                    <option value="">-- Select Location --</option>
                                    @foreach($locations as $location)
                                        <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? 'selected' : '' }}>
                                            {{ $location->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- اختيار المهمة --}}
                            <div class="col-md-6 mb-3">
                                <label for="task_id" class="form-label fw-bold">Task Type</label>
                                <select name="task_id" class="form-select @error('task_id') is-invalid @enderror" required>
                                    <option value="">-- Select Task --</option>
                                    @foreach($tasks as $task)
                                        <option value="{{ $task->id }}" {{ old('task_id') == $task->id ? 'selected' : '' }}>
                                            {{ $task->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- تاريخ التكليف --}}
                        <div class="mb-4">
                            <label for="assigned_date" class="form-label fw-bold">Assignment Date</label>
                            <input type="date" name="assigned_date" class="form-control @error('assigned_date') is-invalid @enderror" 
                                   required value="{{ old('assigned_date', date('Y-m-d')) }}">
                        </div>

                        <hr class="my-4 opacity-25">

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('assignments.index') }}" class="btn btn-light px-4">Cancel</a>
                            <button type="submit" class="btn btn-primary px-5 fw-bold">Confirm Assignment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection