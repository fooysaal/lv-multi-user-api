@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('verification.verify') }}">
                        @csrf

                        <div class="form-group">
                            <label for="otp">{{ __('OTP') }}</label>
                            <input id="otp" type="text" class="form-control @error('otp') is-invalid @enderror" name="otp">

                            @error('otp')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Verify') }}
                            </button>
                        </div>
                    </form>

                    <form method="POST" action="{{ route('verification.resend') }}" class="mt-3">
                        @csrf

                        <button type="submit" class="btn btn-link">{{ __('Resend OTP') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection