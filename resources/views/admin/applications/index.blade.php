@extends('layouts.app')

@section('content')
<div class="container mt-4">
    
    {{-- عنوان الصفحة --}}
    <h2 class="fw-bold mb-4 text-dark text-center">Manage Graduate Applications</h2>

    {{-- قسم البحث (مطابق تماماً لنموذج المتطوعين) --}}
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ url()->current() }}" method="GET" class="row g-2">
                <div class="col-md-4">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           class="form-control" placeholder="Search by name, major, or opportunity...">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-dark w-100 fw-bold" style="border-radius: 8px;">Search</button>
                </div>
                @if(request('search'))
                <div class="col-md-2">
                    <a href="{{ url()->current() }}" class="btn btn-outline-secondary w-100 fw-bold" style="border-radius: 8px;">Clear</a>
                </div>
                @endif
            </form>
        </div>
    </div>

    {{-- جدول عرض الطلبات (كما هو دون تغيير) --}}
    <div class="card shadow-sm border-0" style="border-radius: 15px;">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Email & Phone</th>
                            <th>Major</th>
                            <th>Opportunity</th>
                            <th>CV</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($applications as $app)
                        <tr>
                            <td><span class="fw-bold">{{ $app->full_name }}</span></td>
                            <td>
                                {{ $app->email }} <br> 
                                <small class="text-muted">{{ $app->phone }}</small>
                            </td>
                            <td>{{ $app->major }}</td>
                            <td>{{ $app->task->name ?? 'No Task' }}</td>
                            <td>
                                <a href="{{ asset('storage/' . $app->cv_path) }}" target="_blank" class="btn btn-sm btn-info text-white">View CV</a>
                            </td>
                            <td>
                                <span class="badge rounded-pill bg-{{ $app->status == 'pending' ? 'warning' : ($app->status == 'approved' ? 'success' : 'danger') }}">
                                    {{ ucfirst($app->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    {{-- زر القبول --}}
                                    <form action="{{ route('admin.applications.updateStatus', $app->id) }}" method="POST" class="m-0">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="approved">
                                        <button class="btn btn-sm btn-outline-success px-3">Approve</button>
                                    </form>
                                    
                                    {{-- زر الرفض --}}
                                    <form action="{{ route('admin.applications.updateStatus', $app->id) }}" method="POST" class="m-0">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="rejected">
                                        <button class="btn btn-sm btn-outline-danger px-3">Reject</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach

                        {{-- في حال لم توجد نتائج بحث --}}
                        @if($applications->isEmpty())
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No applications found.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center mt-4">
        {{ $applications->appends(['search' => request('search')])->links() }}
    </div>
</div>
@endsection