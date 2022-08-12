<x-app-layout>

    <x-slot name="header"></x-slot>

    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-4">

                <x-form::error/>

                <div class="card">
                    <div class="card-header">{{ _('Reset password') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <x-form::input type="email" name="email" :label="_('Email address')" required autofocus />

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
