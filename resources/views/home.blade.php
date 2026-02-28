@extends('layouts.app')

@section('content')
<div class="container mt-4">
    {{-- رسائل النجاح --}}
    @if (session('status') || session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4" role="alert" style="border-radius: 10px;">
            {{ session('status') ?? session('success') }}
        </div>
    @endif

    {{-- 1. واجهة الأدمن (تعديل لتشبه النسخة الكاملة) --}}
    @if(Auth::user()->role === 'admin')
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark">Volunteer Assignments</h2>
            <div class="d-flex gap-2">
                <a href="{{ route('volunteers.index') }}" class="btn btn-dark px-4 shadow-sm">Manage Volunteers</a>
                <a href="{{ route('assignments.create') }}" class="btn btn-primary px-4 shadow-sm">+ New Assignment</a>
            </div>
        </div>

        <div class="card shadow-sm border-0" style="border-radius: 15px;">
            <div class="card-body p-4">
                <h5 class="mb-4 text-muted">Recent Task Allocations</h5>
                @if(isset($allAssignments) && $allAssignments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Volunteer</th>
                                    <th>Task</th>
                                    <th>Location</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($allAssignments as $assign)
                                    <tr>
                                        <td><strong>{{ $assign->volunteer->name ?? 'N/A' }}</strong></td>
                                        <td>{{ $assign->task->name }}</td>
                                        <td>{{ $assign->location->name }}</td>
                                        <td>
                                            <span class="badge {{ $assign->status == 'completed' ? 'bg-success' : 'bg-warning text-dark' }} rounded-pill px-3">
                                                {{ ucfirst($assign->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-3">
                            {{ $allAssignments->links() }} {{-- روابط الترقيم --}}
                        </div>
                    </div>
                @else
                    <p class="text-center py-4">No assignments found in the system.</p>
                @endif
            </div>
        </div>

    @else
        {{-- 2. واجهة المتطوع (تصحيح ظهور الحالة) --}}
        <div class="card shadow-sm border-0" style="border-radius: 15px;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="text-success fw-bold mb-0">My Assignments</h4>
                    <span class="badge bg-soft-success text-success">Active Tasks</span>
                </div>
                
                @if(isset($myTasks) && $myTasks->count() > 0)
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Task</th>
                                    <th>Location</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($myTasks as $assignment)
                                    {{-- تعديل: فحص الحالة باستخدام trim و strtolower لضمان الدقة --}}
                                    <tr class="{{ trim(strtolower($assignment->status)) == 'completed' ? 'table-light' : '' }}">
                                        <td><strong>{{ $assignment->task->name }}</strong></td>
                                        <td><i class="bi bi-geo-alt"></i> {{ $assignment->location->name }}</td>
                                        <td>
                                            @if(trim(strtolower($assignment->status)) == 'completed')
                                                <span class="badge bg-success rounded-pill px-3">Completed ✅</span>
                                            @else
                                                <span class="badge bg-warning text-dark rounded-pill px-3">In Progress ⏳</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if(trim(strtolower($assignment->status)) !== 'completed')
                                                <form action="{{ route('tasks.complete', $assignment->id) }}" method="POST" onsubmit="return confirm('Mark this task as finished?')">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success px-3 rounded-pill">Mark as Done</button>
                                                </form>
                                            @else
                                                <span class="text-muted small">No action needed</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" width="80" class="mb-3 opacity-50">
                        <p class="text-muted">No tasks assigned to you yet.</p>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection