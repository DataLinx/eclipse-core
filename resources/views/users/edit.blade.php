@extends('core::layouts.app')

@section('content')
    <form method="post" action="{{ $action }}">
        @csrf
        @if($user->id)
            @method('PUT')
        @endif

        <div class="container">

            <h1>
                @if($user->id)
                    Edit user - {{ $user->email }}
                @else
                    New user
                @endif
            </h1>

            @include('core::shared.errors')

            <div class="card">
                <div class="card-header">Basic information</div>
                <div class="card-body">

                    <div class="form-group">
                        <label for="user-name">Name</label>
                        <input name="name" class="form-control @error('name') is-invalid @enderror" id="user-name" value="{{ old('name', $user->name) }}">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="user-surname">Surname</label>
                        <input name="surname" class="form-control @error('surname') is-invalid @enderror" id="user-surname" value="{{ old('surname', $user->surname) }}">
                        @error('surname')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="user-email">Email address</label>
                        <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="user-email" value="{{ old('email', $user->email) }}">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="card my-3">
                <div class="card-header">Set password</div>
                <div class="card-body">

                    <div class="form-group">
                        <label for="user-password">Password</label>
                        <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" id="user-password" value="{{ old('password') }}">
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>
            </div>

            <button type="submit" name="action" value="save" class="btn btn-primary">Save</button>
            <button type="submit" name="action" value="cancel" class="btn btn-secondary">Cancel</button>

        </div>
    </form>
@endsection
