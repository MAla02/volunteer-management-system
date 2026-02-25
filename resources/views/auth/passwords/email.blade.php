@extends('layouts.app')

@section('content')
<div class="container  mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card  shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-header bg-primary text-white fw-bold" style="border-radius: 15px 15px 0 0;">
                    {{ __('Reset Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success border-0 shadow-sm mb-4" role="alert" style="border-radius:8px;">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                            
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                 name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                       
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary fw-bold" style="border-radius: 8px;">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
