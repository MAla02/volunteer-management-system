@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Assign Volunteer</h2>

    {{-- كود إظهار الأخطاء: إذا نسينا حقل، سيخبرنا النظام فوراً --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('assignments.store') }}">
        @csrf
        
        <div class="mb-3">
            <label for="volunteer_id">Volunteer</label>
            <select name="volunteer_id" class="form-control" required>
                <option value="">Choose...</option>
                @foreach($volunteers as $volunteer)
                    <option value="{{ $volunteer->id }}">{{ $volunteer->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="location_id">Location</label>
            <select name="location_id" class="form-control" required>
                <option value="">Choose...</option>
                @foreach($locations as $location)
                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="task_id">Task</label>
            <select name="task_id" class="form-control" required>
                <option value="">Choose...</option>
                @foreach($tasks as $task)
                    <option value="{{ $task->id }}">{{ $task->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- إضافة حقل التاريخ المفقود --}}
        <div class="mb-3">
            <label for="assigned_date">Assignment Date</label>
            <input type="date" name="assigned_date" class="form-control" required value="{{ date('Y-m-d') }}">
        </div>

        <button type="submit" class="btn btn-success">Assign</button>
    </form>
</div>
@endsection