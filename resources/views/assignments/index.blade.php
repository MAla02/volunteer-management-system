@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow border-0" style="border-radius: 15px;">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-black fw-bold mb-0">Volunteer Assignments</h2>
                <a href="{{ route('assignments.create') }}" class="btn btn-success fw-bold" style="border-radius: 8px;">
                    + New Assignment
                </a>
            </div>

            <div class="bg-light p-3 mb-4" style="border-radius: 10px;">
                <form action="{{ url()->current() }}" method="GET" class="row g-2">
                    <div class="col-md-6">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               class="form-control border-0 shadow-sm" 
                               placeholder="Search by volunteer or task name..." 
                               style="border-radius: 8px;">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-dark w-100 fw-bold" style="border-radius: 8px;">
                            Search
                        </button>
                    </div>
                    @if(request('search'))
                        <div class="col-md-2">
                            <a href="{{ url()->current() }}" class="btn btn-outline-secondary w-100 fw-bold" style="border-radius: 8px;">
                                Clear
                            </a>
                        </div>
                    @endif
                </form>
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
                            <th class="text-black">Task</th>
                            <th class="text-center text-black">Status</th>
                            <th class="text-center text-black" style="min-width: 180px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($assignments as $assignment)
                        <tr>
                            <td class="fw-bold text-primary">{{ $assignment->volunteer->name }}</td>
                            <td>{{ $assignment->location->name }}</td>
                            <td>{{ $assignment->task->name }}</td>
                            <td class="text-center">
                                @if($assignment->status == 'completed')
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2" style="border-radius: 20px;">Finished</span>
                                @elseif($assignment->status == 'cancelled')
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2" style="border-radius: 20px;">Cancelled</span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2" style="border-radius: 20px;">Pending</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('assignments.edit', $assignment->id) }}" 
                                       class="btn btn-sm btn-outline-primary" 
                                       style="border-radius: 8px; width: 75px; font-weight: 500;">
                                         Edit
                                    </a>

                                    <form action="{{ route('assignments.cancel', $assignment->id) }}" 
                                          method="POST" 
                                          id="cancel-form-{{ $assignment->id }}" 
                                          class="m-0">
                                        @csrf
                                        @method('PATCH')
                                        <button type="button" 
                                                onclick="confirmCancel({{ $assignment->id }})" 
                                                class="btn btn-sm btn-outline-danger" 
                                                style="border-radius: 8px; width: 75px; font-weight: 500;">
                                            Cancel
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                No assignments found matching your search criteria.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $assignments->appends(['search' => request('search')])->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function confirmCancel(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This assignment will be marked as cancelled!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, cancel it!',
            cancelButtonText: 'No, keep it',
            borderRadius: '15px'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('cancel-form-' + id).submit();
            }
        })
    }
</script>
@endsection