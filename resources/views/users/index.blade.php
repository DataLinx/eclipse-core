<x-app-layout>

    <x-slot name="header">
        <h1>{{ _('Users') }}</h1>
    </x-slot>

    <div class="container">

        <a class="btn btn-primary mb-3" href="{{ url('users/create') }}">{{ _('Create new user') }}</a>

        <livewire:users-grid />

    </div>
</x-app-layout>
