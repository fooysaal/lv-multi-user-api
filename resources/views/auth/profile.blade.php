@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <!-- Profile Information Section -->
        <div class="col-md-4">
            <div class="card bg-dark">
                <div class="card-header text-light">{{ __('Profile') }}</div>
                <div class="card-body">
                    <!-- Display profile information here -->
                    <p class="text-light">{{ __('Username: ') }}{{ Auth::user()->username }}</p>
                    <p class="text-light">{{ __('Email: ') }}{{ Auth::user()->email }}</p>
                    <!-- You can display additional profile information here -->
                </div>
            </div>

            <!-- Button to trigger Change Password Modal -->
            <div class="card bg-dark mt-3">
                <div class="card-header text-light">{{ __('Manage Credentials') }}</div>
                <div class="card-body">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                        {{ __('Change Password') }}
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                        {{ __('Delete Account') }}
                    </button>
                </div>
            </div>
        </div>

        <!-- Update Profile Section -->
        <div class="col-md-8">
            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="card bg-dark">
                <div class="card-header text-light">{{ __('Update Profile') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="first_name" class="form-label text-light">{{ __('First Name') }}</label>
                            <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') ?? Auth::user()->first_name }}" autofocus>
                            @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="last_name" class="form-label text-light">{{ __('Last Name') }}</label>
                            <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') ?? Auth::user()->last_name }}">
                            @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="username" class="form-label text-light">{{ __('Username') }}</label>
                            <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') ?? Auth::user()->username }}">
                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label text-light">{{ __('Phone') }}</label>
                            <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') ?? Auth::user()->phone }}">
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label text-light">{{ __('Email') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? Auth::user()->email }}">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Update') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title text-light" id="changePasswordModalLabel">{{ __('Change Password') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('profile.password') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="current_password" class="form-label text-light">{{ __('Current Password') }}</label>
                        <input id="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password">
                        @error('current_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="new_password" class="form-label text-light">{{ __('New Password') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label text-light">{{ __('Confirm New Password') }}</label>
                        <input id="password_confirmation" type="password" class="form-control" name="password_confirmation">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Change Password') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-danger">
            <div class="modal-header">
                <h5 class="modal-title text-light" id="deleteAccountModalLabel">{{ __('Delete Account') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('DELETE')

                    <div class="mb-3">
                        <p class="text-light">{{ __('Are you sure you want to delete your account?') }}</p>
                        <label for="account_delete_password" class="form-label text-light">{{ __('Password') }}</label>
                        <input id="account_delete_password" type="password" class="form-control @error('account_delete_password') is-invalid @enderror" name="account_delete_password">
                        @error('account_delete_password')
                            <span class="invalid-feedback text-dark" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-dark">{{ __('Delete') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection