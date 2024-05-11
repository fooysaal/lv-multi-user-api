@extends('layouts.app')

@section('title', 'User Type')

@section('content')
{{-- create a table with edit delete button --}}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <a href="{{ route('user-types.create') }}" class="btn btn-primary">Create User Type</a>
            
                @if (Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ Session::get('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>            

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
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($userTypes as $userType)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>{{ $userType->name }}</td>
                                    <td>{{ $userType->description }}</td>
                                    <td>
                                        <a href="{{ route('user-types.edit', $userType->id) }}" class="btn btn-primary">Edit</a>
                                        <form action="{{ route('user-types.destroy', $userType->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection