<div class="alert alert-{{ $type }} @if ($dismissible) alert-dismissible fade show @endif" role="alert" {{ $attributes }}>
    @if ($dismissible)
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ _('Close') }}"></button>
    @endif
    @if ($heading)
        <h4 class="alert-heading">
            <x-icon name="{{ $icon ?? $getDefaultIcon() }}"/>
            {{ $heading }}
        </h4>
    @endif
    {{ $slot }}
</div>
