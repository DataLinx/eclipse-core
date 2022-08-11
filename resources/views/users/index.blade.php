<x-app-layout>

    <x-slot name="header">
        <h1>{{ _('Users') }}</h1>
    </x-slot>

    <div class="container">

        <a class="btn btn-primary mb-3" href="{{ url('users/create') }}">{{ _('Create new user') }}</a>

        <table class="table table-striped">
            <thead>
                <tr>
                    @foreach($grid->getColumns() as $col)
                        <th>{{ $col->getLabel() }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($grid->getList() as $user)
                    <tr>
                        @foreach($grid->getColumns() as $col)
                            <td>{!! $col->render($user) !!}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</x-app-layout>
