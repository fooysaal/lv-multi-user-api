@extends('layouts.app')

@section('title', 'Account Not Active')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Account Not Active') }}</div>

                    <div class="card-body">
                        {{ __('Your account is not active. Please contact the administrator.') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection