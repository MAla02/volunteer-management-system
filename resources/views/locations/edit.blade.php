@extends('layouts.app')
@section('content')
<div class="container mt-5">

   <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-header bg-primary text-white fw-bold" style="border-radius: 15px 15px 0 0;">
                    Edit Location
                </div>

                 <div class="card-body">

                <form method="POST" action="{{ route('locations.update', $location->id) }}">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Name</label>

            <input type="text" name="name" class="form-control" value="{{ $location->name }}" required>
             @error('name')

                     <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                     </span>
            @enderror
        </div>
          <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary fw-bold" style="border-radius: 8px;">Update</button>
          </div>
    </form>
</div>
@endsection