@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow border-0" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <h2 class="text-black fw-bold mb-4 text-center">Add New Task</h2>

                    <form method="POST" action="{{ route('tasks.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold text-black">Name</label>
                            <input type="text" name="name" class="form-control border-secondary-subtle" 
                                   style="border-radius: 8px; color: black;" required>
                        </div>


                        <div class="mb-4">
                            <label class="form-label fw-bold text-black">Description</label>
                            <textarea name="description" class="form-control border-secondary-subtle" rows="4" 
                                      style="border-radius: 8px; color: black;" required></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success fw-bold" 
                                    style="background-color: #28a745; border: none; padding: 10px; border-radius: 8px;">
                                Save Task
                            </button>
                            <a href="{{ route('tasks.index') }}" class="btn btn-link text-dark text-decoration-none small mt-2 text-center">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection