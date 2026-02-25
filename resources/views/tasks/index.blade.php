@extends('layouts.app')
@section('content')
<div class="container mt-5">

 <div class="card shadow-sm border-0" style="border-radius: 15px;">
        <div class="card-header bg-primary text-white fw-bold" 
        style="border-radius: 15px 15px 0 0;">
            Tasks
        </div>

        <div class="card-body">

        @if(session('success'))
        <div class="alert alert-success  border-0 shadow-sm mb-4" 
        style="border-radius: 8px;">
            {{ session('success') }}
        </div>

        @endif

       <div class="d-flex justify-content-end mb-3">
       <a href="{{ route('tasks.create') }}"  class="btn btn-primary">Add Task</a>
       </div>
         
        <div class="table-responsive">
        <table class="table table-hover align-middle">
        <thead class="table-light">

            <tr>
                <th >Name</th>
                <th class="text-center" style="min-width: 150px;">Actions</th>
            </tr>
         </thead>
        <tbody>

           @forelse($tasks as $task)
            <tr>
                <td>{{ $task->name }}</td>
                <td>

                    <div class="d-flex justify-content-center gap-2">

                    <a href="{{ route('tasks.edit', $task->id) }}"
                     class="btn btn-sm btn-warning">Edit</a>

                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="m-0">
                        @csrf 
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" 
                        style="border-radius: 8px; width: 70px; font-weight: 500;">Delete</button>
                    </form>
                    </div>
                </td>
            </tr>
             @empty
                 <tr>
                  <td colspan="2" class="text-center py-4 text-muted">
                     No tasks found.
                     </td>
                    </tr>
        @endforeach
        </tbody>
    </table>
</div>

  </div>
 </div>
</div>
@endsection