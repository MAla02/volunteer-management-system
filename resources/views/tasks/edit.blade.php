@extends('layouts.app')
@section('content')
<div class="container mt-5">
   

<div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-sm border-0" style="border-radius: 15px;">

                <div class="card-header bg-primary text-white fw-bold" 
                style="border-radius: 15px 15px 0 0;">
                    Edit Task
                </div>

             <div class="card-body">
             <form method="POST" action="{{ route('tasks.update', $task->id) }}">
              @csrf 
              @method('PUT')

            <div class="mb-3">
            <label for="name" class="form-label fw-bold">Name</label>
            <input id="name" type="text" name="name" class="form-control" value="{{ $task->name }}" required>

            </div>

        <div class="d-flex justify-content-end mt-3">
            
                <button type="submit" class="btn btn-primary fw-bold" 
                style="border-radius: 8px;">
                    Update
                  </button>
          </div>
    </form>
</div>
</div>
</div>

</div>
</div>

@endsection