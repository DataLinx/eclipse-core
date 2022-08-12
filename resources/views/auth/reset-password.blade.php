<x-app-layout>

    <x-slot name="header">{{ _('Set new password') }}</x-slot>

    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-4">

                <x-form::error/>

                <div class="card">
                    <div class="card-header">{{ _('Reset password') }}</div>
                    <div class="card-body">

                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <x-form::hidden name="token" value="{{ $request->route('token') }}" />

                            <x-form::input type="email" name="email" :label="_('Email address')" :value="old('email', $request->email)" required autofocus />

                            <x-form::input type="password" name="password" :label="_('New password')" required />

                            <x-form::input type="password" name="password_confirmation" :label="_('Confirm new password')" required />

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    {{ _('Reset password') }}
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

</x-app-layout>
