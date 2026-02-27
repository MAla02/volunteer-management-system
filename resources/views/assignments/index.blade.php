@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow border-0" style="border-radius: 15px;">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="text-black fw-bold mb-0">Volunteer Assignments</h2>
                    <p class="text-muted small mb-0">Sprint 3: Assignment Overview</p>
                </div>
                {{-- زر الإضافة الأساسي للسبرنت الحالي --}}
                <a href="{{ route('assignments.create') }}" class="btn btn-primary fw-bold px-4" style="border-radius: 8px;">
                    + New Assignment
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm mb-4" style="border-radius: 8px;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="text-black">Volunteer</th>
                            <th class="text-black">Location</th>
                            <th class="text-black">Task Type</th>
                            <th class="text-center text-black">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($assignments as $assignment)
                        <tr>
                            <td class="fw-bold">{{ $assignment->volunteer->name }}</td>
                            <td>
                                <span class="text-muted"><i class="bi bi-geo-alt"></i></span> 
                                {{ $assignment->location->name }}
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $assignment->task->name }}</span>
                            </td>
                            <td class="text-center">
                                {{-- تبسيط الحالة لتناسب السبرنت الحالي فقط --}}
                                <span class="badge bg-info-subtle text-info border border-info-subtle px-3 py-2" style="border-radius: 20px;">
                                    Assigned
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                No assignments have been distributed yet.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- الترقيم يظهر فقط إذا كان هناك بيانات مقسمة صفحات --}}
            @if(method_exists($assignments, 'links'))
                <div class="d-flex justify-content-center mt-4">
                    {{ $assignments->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection