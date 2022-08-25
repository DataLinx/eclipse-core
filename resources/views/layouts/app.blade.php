<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SDLX') }}</title>

        @if (config('sdlx.fontawesome_kit_url'))
            <script src="{{ config('sdlx.fontawesome_kit_url') }}" crossorigin="anonymous"></script>
        @endif

        <!-- Styles -->
        <base href="{{ config('app.url') }}" />
        @vite(['resources/js/app.js'])

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
                    @foreach (app(\SDLX\Core\Framework\Output::class)->getToasts() as $toast)
                        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" @if ($toast->isSticky()) data-autohide="false" @else data-delay="10000" @endif>
                            <div class="toast-header bg-{{ $toast->getType() }}">
                                <x-icon name="{{ $toast->getIcon() }}" class="mr-2"/>
                                <strong class="mr-auto">{{ $toast->getTitle() }}</strong>
                                @if (! $toast->isSticky())
                                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
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


    </body>
</html>
