@extends('layouts.app')

@section('content')
<div class="container mt-4">
    {{-- رسائل النجاح البسيطة --}}
    @if (session('status'))
        <div class="alert alert-success border-0 shadow-sm mb-4" role="alert" style="border-radius: 10px;">
            {{ session('status') }}
        </div>
    @endif

    @if(Auth::user()->role === 'admin')
        {{-- واجهة الآدمن: ترحيب فقط (Story #5 & #10 لم تكتمل بعد) --}}
        <div class="row justify-content-center mt-5">
            <div class="col-md-8 text-center">
                <div class="card shadow-sm border-0 p-5" style="border-radius: 20px;">
                    <div class="card-body">
                        <h1 class="fw-bold text-dark mb-3">Welcome, Admin Dashboard</h1>
                        <p class="text-muted fs-5">Use the navigation menu to distribute assignments and manage volunteers.</p>
                        <hr class="my-4 opacity-25">
                        <div class="d-flex justify-content-center gap-3">
                             <span class="badge bg-primary px-3 py-2">Sprint 3: Active</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @else
        {{-- واجهة المتطوع: عرض المهام فقط (Story #12 & #13) --}}
        <div class="card shadow-sm border-0" style="border-radius: 15px;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title text-success fw-bold mb-0">Welcome, {{ Auth::user()->name }}!</h4>
                    <span class="badge bg-light text-dark border">Volunteer Account</span>
                </div>
                <p class="text-muted">Here are your current volunteering assignments for this period.</p>
                <hr>
                
                <h5 class="mb-3 fw-bold">🎯 My Tasks:</h5>

                @if(isset($myTasks) && $myTasks->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Task Name</th>
                                    <th>Location</th>
                                    <th>Assigned Date</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($myTasks as $assignment)
                                    <tr>
                                        <td class="fw-bold">{{ $assignment->task->name ?? 'N/A' }}</td>
                                        <td>
                                            <i class="bi bi-geo-alt text-danger"></i> 
                                            {{ $assignment->location->name ?? 'N/A' }}
                                        </td>
                                        <td>{{ $assignment->assigned_date }}</td>
                                        <td class="text-center">
                                            {{-- عرض الحالة كنص فقط لأن ميزة "التحديث" في سبرنت قادم --}}
                                            <span class="badge rounded-pill bg-info text-dark">Active Task</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info border-0 text-center py-4">
                        <p class="mb-0">You don't have any assigned tasks yet. Check back later!</p>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection