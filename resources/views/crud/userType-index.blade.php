@extends('layouts.app')

@section('title', 'User Type')

@section('content')
{{-- create a table with edit delete button --}}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <select class="form-select bg-dark text-light" style="width: 20%" onchange="window.location.href = this.value;">
                    <option value="{{ route('user-types') }}" {{ request()->is('user-types') ? 'selected' : '' }}>All User Types</option>
                    <option value="{{ route('user-types.trashed') }}" {{ request()->is('user-types/trashed') ? 'selected' : '' }}>Trashed User Types</option>
                </select>
                
                <a href="{{ route('user-types.create') }}" class="btn btn-primary ms-auto">Create User Type</a>
            </div>
            
            @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ Session::get('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif      

            {{-- display all user types --}}
            <div class="card bg-dark">
                <div class="card-header text-light text-center">{{ __('All User Types') }}</div>

                <div class="card-body">
                    <table class="table table-dark table-striped">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($userTypes as $userType)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>{{ $userType->name }}</td>
                                    <td>{{ $userType->description }}</td>
                                    <td>
                                        @if ($userType->is_active == 1 && $userType->deleted_at == null)
                                            <form action="{{ route('user-types.update', $userType->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="is_active" value="changeStatus" />
                                                <button type="submit" class="btn btn-success btn-sm">Active</button>
                                            </form>
                                        @else
                                            <form action="{{ route('user-types.update', $userType->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="is_active" value="changeStatus" />
                                                <button type="submit" class="btn btn-danger btn-sm" @if ($userType->deleted_at != null) disabled @endif>Inactive</button>
                                            </form>
                                        @endif
                                    </td>                                    
                                    <td>
                                        @if ($userType->deleted_at == null)
                                            <a href="{{ route('user-types.edit', $userType->id) }}" class="btn btn-primary btn-sm">Edit</a>
                
                                            @csrf
                                            @method('DELETE')
                                            @if ($userType->name !== 'Admin' && $userType->name !== 'Developer')
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#pdeleteModal{{ $userType->id }}">Delete</button>
                                            @else
                                                <button type="button" class="btn btn-secondary btn-sm" disabled>Delete</button>
                                            @endif
                
                                            <!-- Modal -->
                                            <div class="modal top fade" id="pdeleteModal{{ $userType->id }}" tabindex="-1" aria-labelledby="pdeleteModalLabel{{ $userType->id }}" aria-hidden="true" data-mdb-backdrop="true" data-mdb-keyboard="true">
                                                <div class="modal-dialog modal-sm modal-dialog-centered">
                                                    <div class="modal-content bg-dark">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="pdeleteModalLabel{{ $userType->id }}">Confirm Delete</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to delete this User Type?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <form action="{{ route('user-types.destroy', $userType->id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">Confirm</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <form action="{{ route('user-types.restore', $userType->id) }}" method="POST" class="d-inline-block">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-success btn-sm">Restore</button>
                                            </form>
                                            <form action="{{ route('user-types.forceDelete', $userType->id) }}" method="POST" class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#pdeleteModal{{ $userType->id }}">Delete</button>
                
                                                <!-- Modal -->
                                                <div class="modal top fade" id="pdeleteModal{{ $userType->id }}" tabindex="-1" aria-labelledby="pdeleteModalLabel{{ $userType->id }}" aria-hidden="true" data-mdb-backdrop="true" data-mdb-keyboard="true">
                                                    <div class="modal-dialog modal-sm modal-dialog-centered">
                                                        <div class="modal-content bg-danger">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="pdeleteModalLabel{{ $userType->id }}">Permanent Delete</h5>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to permanently delete this User Type?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <form action="{{ route('user-types.forceDelete', $userType->id) }}" method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-dark">Confirm</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
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