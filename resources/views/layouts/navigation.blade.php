@php
    use SDLX\Core\Framework\Output\Menu;
@endphp

<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'SDLX') }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ _("Toggle navigation") }}">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @foreach (app(Menu::class)->getItems() as $item)
                    @if (is_a($item, Menu\Section::class))
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="javascript:void(0);" role="button" data-bs-toggle="dropdown"
                               aria-expanded="false">
                                {{ $item->getLabel() }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-start">
                                @foreach ($item->getItems() as $subItem)
                                    @if ($subItem === '_divider_')
                                        <li><hr class="dropdown-divider"></li>
                                    @elseif (is_a($subItem, Menu\Section::class))
                                        <li><h6 class="dropdown-header">{{ $subItem->getLabel() }}</h6></li>
                                        @foreach ($subItem->getItems() as $subSubItem)
                                            <li>
                                                <a {!! $subSubItem->isCurrent() ? 'class="dropdown-item active" aria-current="true"' : 'class="dropdown-item"' !!}
                                                   href="{{ $subSubItem->getHref() }}">
                                                    {{ $subSubItem->getLabel() }}
                                                </a>
                                            </li>
                                        @endforeach
                                        @if ( ! $loop->last)
                                            <li><hr class="dropdown-divider"></li>
                                        @endif
                                    @else
                                        <li>
                                            <a {!! $subItem->isCurrent() ? 'class="dropdown-item active" aria-current="true"' : 'class="dropdown-item"' !!}
                                               href="{{ $subItem->getHref() }}">
                                                {{ $subItem->getLabel() }}
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a {!! $item->isCurrent() ? 'class="nav-link active" aria-current="page"' : 'class="nav-link"' !!}
                               href="{{ $item->getHref() }}"
                                data-key="{{ $item->getKey() }}">{{ $item->getLabel() }}</a>
                        </li>
                    @endif
                @endforeach
            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                       aria-expanded="false">
                        {{ auth()->user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ _('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
