@extends('layouts.app')

{{-- UI Design for Story #3 - Design by Ola --}}
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-lg" style="border-radius: 15px;">
                <div class="card-header bg-primary text-white py-3" style="border-radius: 15px 15px 0 0;">
                    <h5 class="mb-0 fw-bold text-center">Add New Location</h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('locations.store') }}">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-bold">Location Name</label>
                            <input type="text" name="name" class="form-control form-control-lg border-primary-subtle" 
                                   placeholder="Enter location name" style="border-radius: 10px;" required>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold" style="border-radius: 10px;">Save Location</button>
                            <a href="{{ route('locations.index') }}" class="btn btn-link text-decoration-none text-muted">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection