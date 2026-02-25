@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center ">
        <div class="col-md-8">

            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-header bg-primary text-white fw-bold" style="border-radius: 15px 15px 0 0;">
                      {{ __('Confirm Password') }}
                    </div>

                <div class="card-body">
                    <p class="mb-4"> {{ __('Please confirm your password before continuing.') }} </p>

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                    
                            <div class="d-flex justify-content-between align-items-center">
                                <button type="submit" class="btn btn-primary fw-bold" style="border-radius: 8px;">
                                    {{ __('Confirm Password') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link p-0" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            
                        </div>
                    </form>
                </div>
            </div>
    </div>
</div>
@endsection
