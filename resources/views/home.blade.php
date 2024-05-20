@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (Session::has('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ Session::get('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card bg-dark">
                <div class="card-header text-light">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    <table class="table table-dark table-striped">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Username</th>
                                <th scope="col">Email</th>
                                <th scope="col">User Type</th>
                                <th scope="col">Created By</th>
                                <th scope="col">Verified</th>
                                @if(Auth::user()->isAdmin())
                                    <th scope="col">Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($viewBag['users'] as $user)
                                <tr @if($user->deleted_at) class="table-danger" @endif>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->userType->name }}</td>
                                    <td>{{ $user->created_by }}</td>
                                    <td>
                                        @if($user->email_verified_at === null)
                                            <span class="badge badge-warning bg-danger">No</span>
                                        @else
                                            <span class="badge badge-primary bg-success">Verified</span>
                                        @endif
                                    </td>
                                    @if(Auth::user()->isAdmin())
                                        <td>
                                            @if($user->deleted_at === null)
                                            {{-- Trigger modal --}}
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#viewUserModal{{ $user->id }}">
                                                View
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="viewUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="viewUserModalLabel{{ $user->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-scrollable">
                                                    <div class="modal-content bg-dark">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="viewUserModalLabel{{ $user->id }}">User Info</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p><strong>Name:</strong> {{ $user->first_name }} {{ $user->last_name }}</p>
                                                            <p><strong>Email:</strong> {{ $user->email }}</p>
                                                            <p><strong>Phone:</strong> {{ $user->phone }}</p>
                                                            <p><strong>User Type:</strong> {{ $user->user_type_name }}</p> <!-- Adjusted for UserResource -->
                                                            <p><strong>Created By:</strong> {{ $user->created_by }}</p>
                                                            <p><strong>Verified At:</strong> {{ $user->email_verified_at }}</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Edit modal where only user type can be updated --}}
                                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">
                                                Edit
                                            </button>

                                            <!-- Edit Modal -->
                                            <div class="modal fade top" id="editUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="editUserModalLabel{{ $user->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content bg-dark">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editUserModalLabel{{ $user->id }}">Edit User</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-light">
                                                            <form action="" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="mb-3">
                                                                    <label for="user_type_id" class="form-label text-light">{{ __('User Type') }}</label>
                                                                    <select id="user_type_id" class="form-select @error('user_type_id') is-invalid @enderror" name="user_type_id">
                                                                        @foreach ($viewBag['userTypes'] as $userType)
                                                                            <option value="{{ $userType->id }}" {{ $userType->id === $user->user_type_id ? 'selected' : '' }}>{{ $userType->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('user_type_id')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <button type="submit" class="btn btn-primary">Update</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            @if($user->deleted_at)
                                                <form action="{{ route('users.restore', $user->id) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-success btn-sm">Retrieve</button>
                                                </form>
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#pdeleteModal{{ $user->id }}">Delete Permanently</button>

                                                <!-- Permanent Delete Modal -->
                                                <div class="modal top fade" id="pdeleteModal{{ $user->id }}" tabindex="-1" aria-labelledby="pdeleteModalLabel{{ $user->id }}" aria-hidden="true" data-mdb-backdrop="true" data-mdb-keyboard="true">
                                                    <div class="modal-dialog modal-sm modal-dialog-centered">
                                                        <div class="modal-content bg-danger">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="pdeleteModalLabel{{ $user->id }}">Permanent Delete</h5>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to permanently delete this User?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <form action="{{ route('users.forceDelete', $user->id) }}" method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-dark">Confirm</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="7">No Users found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>    
</div>

@endsection
