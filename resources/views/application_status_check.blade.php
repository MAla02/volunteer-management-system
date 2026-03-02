@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-body p-5">
                    <h3 class="text-center fw-bold mb-4">Track Your Application</h3>
                    <p class="text-center text-muted mb-4">Enter the email address you used during application to check your status.</p>
                    
                    {{-- نموذج البحث عن الإيميل --}}
                    <form action="{{ route('application.status.check') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Email Address</label>
                            <input type="email" name="email" class="form-control form-control-lg border-2" placeholder="example@mail.com" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 btn-lg fw-bold shadow-sm">
                            <i class="bi bi-search me-2"></i> Track Now
                        </button>
                    </form>

                    {{-- عرض النتائج في حال وجود طلب --}}
                    @if(isset($application))
                        <hr class="my-5">
                        <div class="result-section text-center">
                            <h5 class="text-dark">Welcome, <span class="fw-bold text-primary">{{ $application->full_name }}</span></h5>
                            <p class="text-muted">Status for <strong>{{ $application->task->name }}</strong>:</p>
                            
                            @if($application->status == 'pending')
                                <div class="alert alert-warning border-0 py-3 shadow-sm">
                                    <h4 class="mb-1">⏳ Pending</h4>
                                    <p class="mb-0 small">Your application is still under review. Please check back later.</p>
                                </div>
                            @elseif($application->status == 'approved')
                                <div class="alert alert-success border-0 py-3 shadow-sm">
                                    <h4 class="mb-1">✅ Approved</h4>
                                    <p class="mb-0 small">Congratulations! Your application has been accepted. We will contact you soon.</p>
                                </div>
                            @else
                                <div class="alert alert-danger border-0 py-3 shadow-sm">
                                    <h4 class="mb-1">❌ Rejected</h4>
                                    <p class="mb-0 small">We regret to inform you that your application was not selected. Good luck next time!</p>
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- عرض رسالة خطأ في حال لم يتم العثور على الإيميل --}}
                    @if(session('error'))
                        <div class="alert alert-danger mt-4 text-center border-0 shadow-sm">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="{{ url('/') }}" class="text-decoration-none text-muted">← Back to Home</a>
            </div>
        </div>
    </div>
</div>

<style>
    /* لمسة جمالية بسيطة للأزرار والحقول */
    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: none;
    }
    .btn-primary {
        background-color: #0d6efd;
        border: none;
        transition: transform 0.2s;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
    }
</style>
@endsection