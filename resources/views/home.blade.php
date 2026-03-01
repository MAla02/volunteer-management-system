@extends('layouts.app')

@section('content')
<div class="container mt-4">
    {{-- رسائل الحالة (نجاح التحديث أو غيره) --}}
    @if (session('status'))
        <div class="alert alert-success border-0 shadow-sm mb-4" role="alert" style="border-radius: 10px;">
            {{ session('status') }}
        </div>
    @endif

    {{-- بداية الجزء الذكي: التحقق من دور المستخدم --}}
    @if(Auth::user()->role === 'admin')
        
        <div class="row">
            <div class="col-md-12 mb-4">
                <h2 class="fw-bold">Welcome to Admin Dashboard</h2>
                <p class="text-muted">Quick overview of the system status</p>
            </div>
            
            {{-- كروت الإحصائيات الأربعة --}}
            <div class="col-md-3">
                <div class="card shadow-sm border-0 bg-primary text-white mb-3" style="border-radius: 12px;">
                    <div class="card-body p-4 text-center">
                        <h6 class="opacity-75">Total Volunteers</h6>
                        <h3 class="fw-bold">{{ $stats['volunteers_count'] ?? 0 }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 bg-success text-white mb-3" style="border-radius: 12px;">
                    <div class="card-body p-4 text-center">
                        <h6 class="opacity-75">Completed Tasks</h6>
                        <h3 class="fw-bold">{{ $stats['tasks_completed'] ?? 0 }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 bg-warning text-dark mb-3" style="border-radius: 12px;">
                    <div class="card-body p-4 text-center">
                        <h6 class="opacity-75">Pending Requests</h6>
                        <h3 class="fw-bold">{{ $stats['pending_requests'] ?? 0 }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 bg-info text-white mb-3" style="border-radius: 12px;">
                    <div class="card-body p-4 text-center">
                        <h6 class="opacity-75">Total Assignments</h6>
                        <h3 class="fw-bold">{{ $stats['total_assignments'] ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>

    @else
        {{-- واجهة المتطوع --}}
        <div class="card shadow-sm border-0" style="border-radius: 15px;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title text-success mb-0">Welcome, {{ Auth::user()->name }}!</h4>
                    {{-- تم حذف الزر من هنا بناءً على طلبك لوجوده في القائمة العلوية --}}
                </div>
                <hr>
                
                <h5 class="mb-3">🎯 My Tasks:</h5>

                @if(isset($myTasks) && $myTasks->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Task Name</th>
                                    <th>Location</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($myTasks as $assignment)
                                    <tr class="{{ $assignment->status == 'completed' ? 'table-success' : '' }}">
                                        <td>{{ $assignment->task->name }}</td>
                                        <td>{{ $assignment->location->name }}</td>
                                        <td>{{ $assignment->assigned_date }}</td>
                                        <td>
                                            @if($assignment->status == 'completed')
                                                <span class="badge bg-success">Completed ✅</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Pending ⏳</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($assignment->status !== 'completed')
                                                <form action="{{ route('tasks.complete', $assignment->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success">Mark as Done</button>
                                                </form>
                                            @else
                                                <span class="text-muted">Finished</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info border-0">
                        You don't have any assigned tasks yet. Check back later!
                    </div>
                @endif
            </div>
        </div>

        {{-- Modal الإعدادات الذكي --}}
        <div class="modal fade" id="settingsModal" tabindex="-1" aria-labelledby="settingsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius: 15px;">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-bold" id="settingsModalLabel">Update My Settings</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('profile.update') }}" method="POST" autocomplete="off">
                        @csrf
                        {{-- حقول تضليل لمنع المتصفح من وضع الإيميل تلقائياً --}}
                        <input type="text" style="display:none">
                        <input type="password" style="display:none">

                        <div class="modal-body pb-0">
                            {{-- حقل الهاتف: يعرض القيمة الحالية تلقائياً --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">Phone Number</label>
                                <input type="text" name="phone" class="form-control shadow-sm" 
                                       value="{{ Auth::user()->phone }}" 
                                       autocomplete="new-password"
                                       style="border-radius: 8px;">
                                
                            </div>

                            <hr class="my-4">
                            
                            {{-- حقول كلمة المرور --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">New Password</label>
                                <input type="password" name="password" class="form-control shadow-sm" 
                                       style="border-radius: 8px;" autocomplete="new-password">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control shadow-sm" 
                                       style="border-radius: 8px;" autocomplete="new-password">
                            </div>
                        </div>

                        <div class="modal-footer border-0 pt-3">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success px-4" style="border-radius: 8px;">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection