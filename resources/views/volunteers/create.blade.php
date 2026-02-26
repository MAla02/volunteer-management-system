@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            
            {{-- هذا هو التعديل المطلوب لإظهار رسالة النجاح حسب الـ Acceptance Criteria --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Add New Volunteer</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('volunteers.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter full name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="example@mail.com" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" placeholder="059xxxxxxx" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Save Volunteer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection