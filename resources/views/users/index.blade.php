@extends('core::layouts.app')

@section('content')
    <div class="container">

        <h1>Users</h1>

        <a class="btn btn-primary mb-3" href="{{ url('users/create') }}">Create new user</a>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full name</th>
                    <th>Email</th>
                    <th>Created</th>
                    <th>Last seen</th>
                    <th>Login count</th>
                    <th>Action</th>
                </tr>
            </thead>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->getFullName() }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td>{{ $user->seen_at }}</td>
                    <td>{{ $user->login_count }}</td>
                    <td>
                        <a href="{{ url("/users/{$user->id}/edit") }}">Edit</a>
                        <a class="user-delete" data-id="{{ $user->id }}" href="javascript:void(0);">Delete</a>
                    </td>
                </tr>
            @endforeach
        </table>

    </div>

@endsection
