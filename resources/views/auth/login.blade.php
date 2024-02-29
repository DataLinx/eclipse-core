<x-app-layout>

    <x-slot name="header"></x-slot>

    <div class="container">
        <div class="justify-items-center">
            <div class="card">
                <div class="card-header">{{ _('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <x-form::input type="email" name="email" label="{{ _('E-mail address') }}" required autocomplete="email" autofocus />

                        <x-form::input type="password" name="password" label="{{ _('Password') }}" required autocomplete="current-password" />

                        <x-form::switcher name="remember" label="{{ _('Remember me') }}" />

                        <div class="d-grid">

                            <button type="submit" class="btn btn-primary">
                                {{ _('Login') }}
                            </button>

                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ _('Forgot your password?') }}
                                </a>
                            @endif

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
