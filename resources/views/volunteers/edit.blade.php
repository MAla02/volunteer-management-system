@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <h2 class="mb-4 text-center">Edit Volunteer</h2>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Error Messages --}}
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

    <form action="{{ route('volunteers.update', $volunteer->id) }}" method="POST">
    @csrf
    @method('PUT')
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name', $volunteer->name) }}" class="form-control" required placeholder="Enter full name " autofocus>

        </div>
        <div class="mb-3">
            <label>Email</label>
<input type="email" name="email" value="{{ old('email', $volunteer->email) }}" class="form-control" required placeholder="Enter the Email ">
        </div>

        <div class="mb-3">
            <label>Phone</label>

   <input type="text" name="phone" value="{{ old('phone', $volunteer->phone) }}" class="form-control" required  placeholder="Enter 10 digit number ">
        </div>

       <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-success">Update</button>
                    <button type="reset" class="btn btn-secondary">Clear</button>
                </div>
    </form>
</div>
</div>
</div>

@endsection

