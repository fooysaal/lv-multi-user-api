@extends('layouts.app')

@section('title', 'User Type')

@section('content')
{{-- form to create user types --}}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card bg-dark">
                <div class="card-header text-light">{{ __('Create User Type') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('user-types.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label text-light">{{ __('Name') }}</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label text-light">{{ __('Description') }}</label>
                            <input id="description" type="text" class="form-control" name="description" value="{{ old('description') }}" autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="is_active" class="form-label text-light">{{ __('Status') }}</label>
                            <select id="is_active" class="form-select" name="is_active">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection