@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            {{-- واجهة ترحيبية بسيطة فقط --}}
            <div class="card shadow-sm border-0 p-5" style="border-radius: 20px;">
                <div class="card-body">
                    <h1 class="fw-bold text-dark mb-3">Welcome, {{ Auth::user()->name }}!</h1>
                    <p class="text-muted fs-5">You are successfully logged in as <span class="badge bg-dark px-3">{{ ucfirst(Auth::user()->role) }}</span></p>
                    
                    <hr class="my-4 opacity-25">
                    
                    <p class="text-secondary">Please use the navigation menu to manage locations or tasks.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection