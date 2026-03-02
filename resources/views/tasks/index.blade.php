@extends('layouts.app')

@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Tasks</h2>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">Add Task</a>
    </div>

    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form action="{{ url()->current() }}" method="GET" class="row g-2">
                <div class="col-md-5">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           class="form-control" placeholder="Search by task name or description...">
                </div>
               <div class="col-md-2">
               <button type="submit" class="btn btn-dark w-100 fw-bold" style="border-radius: 8px;">Search</button>
               </div>
               @if(request('search'))
               <div class="col-md-2">
               <a href="{{ url()->current() }}" class="btn btn-outline-secondary w-100 fw-bold" style="border-radius: 8px;">Clear Search</a>
              </div>
              @endif
            </form>
        </div>
    </div>
    <table class="table table-striped border mt-3">
        <thead class="table-light">
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($tasks as $task)
            <tr>
                <td>{{ $task->name }}</td>
                <td>
                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    
                    {{-- التعديل المخصص لرسالة الحذف --}}
                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline" id="delete-task-{{ $task->id }}">
                        @csrf @method('DELETE')
                        <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $task->id }})">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="2" class="text-center text-muted">No tasks found matching your search.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center mt-4">
        {{ $tasks->appends(['search' => request('search')])->links() }}
    </div>
</div>
@endsection

{{-- قسم السكريبت --}}
@section('scripts')
<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This task will be deleted forever!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // تنفيذ الحذف للفورم المحدد
            document.getElementById('delete-task-' + id).submit();
        }
    })
}
</script>
@endsection