<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        @if (config('ocelot.fontawesome_kit_url'))
            <script src="{{ config('ocelot.fontawesome_kit_url') }}" crossorigin="anonymous"></script>
        @endif

        <!-- Styles -->
        <base href="{{ config('app.url') }}" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    </head>
    <body>
        <div>
            @auth
                @include('core::layouts.navigation')

                <header class="container py-3">
                    {{ $header }}
                </header>
            @endauth

            <main>
                {{ $slot }}

                <div id="toast-container" aria-live="polite" aria-atomic="true">
                    @foreach (app(\Ocelot\Core\Framework\Output::class)->getToasts() as $toast)
                        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" @if ($toast->isSticky()) data-autohide="false" @else data-delay="10000" @endif>
                            <div class="toast-header bg-{{ $toast->getType() }}">
                                <x-icon name="{{ $toast->getIcon() }}" class="mr-2"/>
                                <strong class="mr-auto">{{ $toast->getTitle() }}</strong>
                                @if (! $toast->isSticky())
                                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                @endif
                            </div>
                            <div class="toast-body">
                                {{ $toast->getMessage() }}
                                @if ($toast->hasLinks())
                                    <div class="toast-action">
                                        @foreach ($toast->getLinks() as $label => $href)
                                            <a class="btn btn-light" href="{{ $href ?? 'javascript:void(0);' }}">{{ $label }}</a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

            </main>
        </div>

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>

    </body>
</html>
