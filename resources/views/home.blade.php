@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(Auth::user()->isAdmin())
            <div class="d-flex justify-content-between align-items-start mb-2">
                <select class="form-select bg-dark text-light" style="width: 20%" onchange="window.location.href = this.value;">
                    <option value="{{ route('home') }}" {{ request()->is('home') ? 'selected' : '' }}>All Users</option>
                    <option value="{{ route('users.trashed') }}" {{ request()->is('users/trashed') ? 'selected' : '' }}>Archived Users</option>
                </select>
            </div>
            @endif

            @if (Session::has('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ Session::get('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card bg-dark">
                <div class="card-header text-light">{{ __('Dashboard') }}</div>
            
                {{-- show registered users without the logged-in user --}}
                <div class="card-body">
                    <table class="table table-dark table-striped">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Username</th>
                                <th scope="col">Email</th>
                                <th scope="col">User Type</th>
                                <th scope="col">Created By</th>
                                @if(Auth::user()->isAdmin())
                                    <th scope="col">Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                @if ($user->id !== Auth::user()->id)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->userType->name }}</td>
                                        <td>{{ $user->created_by }}</td>
                                        @if(Auth::user()->isAdmin())
                                            <td>
                                                @if($user->deleted_at === null)
                                                    {{-- trigger modal --}}
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
                                                                    <p><strong>User Type:</strong> {{ $user->userType->name }}</p>
                                                                    <p><strong>Created By:</strong> {{ $user->created_by }}</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <form action="{{ route('users.restore', $user->id) }}" method="POST" style="display: inline-block;">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-success btn-sm">Retrieve</button>
                                                    </form>
                                                    <form action="{{ route('users.forceDelete', $user->id) }}" method="POST" style="display: inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">Delete Permanently</button>
                                                    </form>
                                                @endif
                                            </td>
                                        @endif
                                    </tr>
                                @endif
                            @empty
                                <tr class="text-center">
                                    <td colspan="7">No User Types found.</td>
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
