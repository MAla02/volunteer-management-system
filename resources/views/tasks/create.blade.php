@extends('layouts.app')
@section('content')
<div class="container mt-5">
    
 <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-header bg-primary text-white fw-bold" style="border-radius: 15px 15px 0 0;">
                    Add Task
                </div>

            <div class="card-body">
             <form method="POST" action="{{ route('tasks.store') }}">
             @csrf

            <div class="mb-3">
            <label  for="name" class="form-label fw-bold">Name</label>
            <input id="name" type="text" name="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success fw-bold"style="border-radius: 8px;">Save</button>
    </form>
</div>
</div>

</div>

</div>

</div>

@endsection