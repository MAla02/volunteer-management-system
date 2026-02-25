@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <h2>All Assignments</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    
    @endif

   <a href="{{ route('assignments.create') }}" class="btn btn-success mb-3" style="border-radius: 8px;">
        + Assign New Volunteer
    </a>

    <table class="table table-hover align-middle">
        <thead><tr>
            <th>Volunteer</th>
            <th>Location</th>
            <th>Task</th>
            <th>Status</th>
             <th>Actions</th>

        </tr>  
            </thead>
        <tbody>
        @foreach($assignments as $assignment)
            <tr>
                <td>{{ $assignment->volunteer->name }}</td>
                <td>{{ $assignment->location->name }}</td>
                <td>{{ $assignment->task->name }}</td>

                 <td>
                    @if($assignment->status == 'completed')
                        <span class="badge bg-success" style="border-radius: 12px;">Finished</span>
                    @elseif($assignment->status == 'cancelled')
                        <span class="badge bg-danger" style="border-radius: 12px;">Cancelled</span>
                    @else
                        <span class="badge bg-warning text-dark" style="border-radius: 12px;">Pending</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('assignments.edit', $assignment->id) }}" 
                       class="btn btn-sm btn-outline-primary" style="border-radius: 8px; width: 75px;">
                        Edit
                    </a>
                </td>

              @empty
              <tr>
                <td colspan="5" class="text-center text-muted py-4">
                    No assignments yet.
                </td>
            </tr>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection