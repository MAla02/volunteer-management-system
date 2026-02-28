@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow border-0" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <h2 class="text-black fw-bold mb-4 text-center">Apply for Opportunity</h2>
                    
                    <p class="text-center text-muted mb-4">Position: <span class="fw-bold text-black">{{ $task->name }}</span></p>

                    @if ($errors->any())
                    <div class="alert alert-danger shadow-sm border-0">
                    <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                    </div>
                    @endif

                    {{-- عرض رسالة نجاح التقديم --}}
                    @if(session('success'))
                        <div class="alert alert-success border-0 shadow-sm mb-3">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('apply.store') }}" enctype="multipart/form-data">
                        @csrf
                        {{-- الحقل المخفي لرقم المهمة --}}
                        <input type="hidden" name="task_id" value="{{ $task->id }}">

                        <div class="mb-3">
                            <label class="form-label fw-bold text-black">Full Name</label>
                            <input type="text" name="full_name" class="form-control border-secondary-subtle @error('full_name') is-invalid @enderror" 
                                   style="border-radius: 8px; color: black;" value="{{ old('full_name') }}" required>
                            @error('full_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- أضفنا حقل الإيميل هنا عشان نعرف نبعت رد للخريج --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold text-black">Email Address</label>
                            <input type="email" name="email" class="form-control border-secondary-subtle @error('email') is-invalid @enderror" 
                                   style="border-radius: 8px; color: black;" value="{{ old('email') }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-black">Phone Number</label>
                            <input type="text" name="phone" class="form-control border-secondary-subtle @error('phone') is-invalid @enderror" 
                                   style="border-radius: 8px; color: black;" value="{{ old('phone') }}" required>
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- حقل التخصص مهم عشان الأدمن يقيم الطلب --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold text-black">Major</label>
                            <input type="text" name="major" class="form-control border-secondary-subtle @error('major') is-invalid @enderror" 
                                   style="border-radius: 8px; color: black;" value="{{ old('major') }}" required>
                            @error('major') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-black">Why are you interested?</label>
                            <textarea name="message" class="form-control border-secondary-subtle @error('message') is-invalid @enderror" rows="3" 
                                      style="border-radius: 8px; color: black;" required>{{ old('message') }}</textarea>
                            @error('message') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-black">Upload CV (PDF only)</label>
                            <input type="file" name="cv_path" class="form-control border-secondary-subtle @error('cv_path') is-invalid @enderror" 
                                   style="border-radius: 8px; color: black;" required>
                            @error('cv_path') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success fw-bold" 
                                    style="background-color: #28a745; border: none; padding: 10px; border-radius: 8px;">
                                Submit Application
                            </button>
                            <a href="{{ url('/') }}" class="btn btn-link text-dark text-decoration-none small mt-2 text-center">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection