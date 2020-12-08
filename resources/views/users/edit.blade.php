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

            <x-form::error/>

            <div class="card">
                <div class="card-header">Basic information</div>
                <div class="card-body">

                    <x-form::input name="name" :object="$user" :label="_('Name')" required autocomplete="off"/>

                    <x-form::input name="surname" :object="$user" :label="_('Surname')" required autocomplete="off"/>

                    <x-form::input type="email" name="email" :object="$user" :label="_('Email address')" required autocomplete="off"/>

                </div>
            </div>

            <div class="card my-3">
                <div class="card-header">Set password</div>
                <div class="card-body">

                    <x-form::input type="password" name="password" :label="_('Password')"/>

                </div>
            </div>

            <button type="submit" name="action" value="save" class="btn btn-primary">Save</button>
            <button type="submit" name="action" value="cancel" class="btn btn-secondary">Cancel</button>

        </div>
    </form>
@endsection
