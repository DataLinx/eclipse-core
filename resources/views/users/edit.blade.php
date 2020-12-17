@extends('core::layouts.app')

@section('content')
    <form method="post" action="{{ $action }}" autocomplete="off" enctype="multipart/form-data">
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

                    <x-form::input name="name" :object="$user" :label="_('Name')" required/>

                    <x-form::input name="surname" :object="$user" :label="_('Surname')" required/>

                    <x-form::input type="email" name="email" :object="$user" :label="_('Email address')" required/>

                </div>
            </div>

            <div class="card my-3">
                <div class="card-header">{{ _('User image') }}</div>
                <div class="card-body">

                    @if ($user->image)
                        <img src="img/{{ $user->image }}?w=200&h=200" />
                    @endif

                    <x-form::file name="image" :label="_('Upload new image')" size="sm"/>

                    @if ($user->image)
                        <x-form::switcher name="delete_image" :label="_('Delete existing image')" :help="_('Select this if you just want to delete the existing image without uploading a new one.')"/>
                    @endif

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
