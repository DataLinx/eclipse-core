@extends('core::layouts.app')

@section('content')
    <div class="container">

        <h1>{{ _('Users') }}</h1>

        <a class="btn btn-primary mb-3" href="{{ url('users/create') }}">{{ _('Create new user') }}</a>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>{{ _('Full name')  }}</th>
                    <th>{{ _('Email address') }}</th>
                    <th>{{ _('Created on') }}</th>
                    <th>{{ _('Last seen') }}</th>
                    <th>{{ _('Login count') }}</th>
                    <th>{{ _('Action') }}</th>
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
                        <a class="user-delete" data-id="{{ $user->id }}" href="javascript:void(0);">{{ _('Delete') }}</a>
                    </td>
                </tr>
            @endforeach
        </table>

    </div>

@endsection
