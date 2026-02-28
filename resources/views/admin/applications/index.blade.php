@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0" style="border-radius: 15px;">
        <div class="card-body p-4">
            <h2 class="fw-bold mb-4 text-dark text-center">Manage Graduate Applications</h2>
            
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Email & Phone</th>
                        <th>Major</th>
                        <th>Opportunity</th>
                        <th>CV</th>
                        <th>Status</th>
                        <th class="text-center">Action</th> {{-- توسيط العنوان --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach($applications as $app)
                    <tr>
                        <td><span class="fw-bold">{{ $app->full_name }}</span></td>
                        <td>{{ $app->email }} <br> <small class="text-muted">{{ $app->phone }}</small></td>
                        <td>{{ $app->major }}</td>
                        <td>{{ $app->task->name }}</td>
                        <td>
                            <a href="{{ asset('storage/' . $app->cv_path) }}" target="_blank" class="btn btn-sm btn-info text-white">View CV</a>
                        </td>
                        <td>
                            <span class="badge rounded-pill bg-{{ $app->status == 'pending' ? 'warning' : ($app->status == 'approved' ? 'success' : 'danger') }}">
                                {{ ucfirst($app->status) }}
                            </span>
                        </td>
                        <td>
                            {{-- هذا الجزء هو الذي تم تعديله لترتيب الأزرار أفقياً --}}
                            <div class="d-flex justify-content-center gap-2">
                                <form action="{{ route('admin.applications.updateStatus', $app->id) }}" method="POST" class="m-0">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="approved">
                                    <button class="btn btn-sm btn-outline-success px-3">Approve</button>
                                </form>
                                
                                <form action="{{ route('admin.applications.updateStatus', $app->id) }}" method="POST" class="m-0">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="rejected">
                                    <button class="btn btn-sm btn-outline-danger px-3">Reject</button>
                                </form>
                            </div>
                            {{-- نهاية التعديل --}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection