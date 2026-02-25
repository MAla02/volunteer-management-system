@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-header  bg-primary text-white fw-bold"style="border-radius: 15px 15px 0 0;">{{ __('Login') }}</div>

                <div class="card-body">
                        <form method="POST" action="{{ route('login') }}" autocomplete="off">
                        @csrf
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                 <!-- <input id="email" type="email" name="email" value="" autocomplete="off" /> -->
                                  <input id="email" type="email" name="email" value="" autocomplete="new-email" class="form-control" required autofocus />



                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                 <!-- <input id="password" type="password" name="password" value="" autocomplete="off" /> -->
                                  <input id="password" type="password" name="password" value="" autocomplete="new-password" class="form-control" required />



                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>



                       
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary fw-bold" style="border-radius: 8px;">
                                    {{ __('Login') }}
                                </button>

                           
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
