@php
    use Eclipse\Core\Framework\Output;
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Eclipse') }}</title>

        @if (config('eclipse.fontawesome_kit_url'))
            <script src="{{ config('eclipse.fontawesome_kit_url') }}" crossorigin="anonymous"></script>
        @endif

        <!-- Styles -->
        <base href="{{ config('app.url') }}" />
        @vite(['resources/js/app.js'])

        <livewire:styles />

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

                <div aria-live="polite" aria-atomic="true">
                    <div class="toast-container position-fixed bottom-0 start-50 translate-middle-x pb-2 pb-sm-5 px-2">
                        @foreach (app(Output::class)->getToasts() as $toast)
                            <div class="toast toast-{{ $toast->getType() }}" role="alert" aria-live="assertive" aria-atomic="true"
                                 @if ($toast->isSticky()) data-bs-autohide="false" @else data-bs-delay="10000" @endif>
                                <div class="toast-header">
                                    <x-icon name="{{ $toast->getIcon() }}" class="mr-2"/>
                                    <strong class="me-auto">{{ $toast->getTitle() }}</strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                                <div class="toast-body">
                                    {{ $toast->getMessage() }}
                                    @if ($toast->hasLinks())
                                        <div class="mt-2 pt-2 border-top">
                                            @foreach ($toast->getLinks() as $label => $href)
                                                <a class="btn btn-light btn-sm" href="{{ $href ?? 'javascript:void(0);' }}">{{ $label }}</a>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </main>
        </div>

        <livewire:scripts />

    </body>
</html>
