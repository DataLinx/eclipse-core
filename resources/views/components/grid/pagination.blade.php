<nav class="grid-pagination d-flex justify-content-end" aria-label="Pagination navigation">
    <div class="input-group mb-3">
        @if ($paginator->onFirstPage())
            <button class="btn btn-outline-secondary" type="button" disabled><x-icon name="backward-step" /></button>
            <button class="btn btn-outline-secondary" type="button" disabled><x-icon name="caret-left" /></button>
        @else
            {{-- For some reason, if buttons are used instead of anchors, "first page" and "previous page" do not work --}}
            <a class="btn btn-outline-secondary" href="javascript:void(0);" aria-label="{{ _('First page') }}" title="{{ _('First page') }}" wire:click="gotoPage(0)"><x-icon name="backward-step" /></a>
            <a class="btn btn-outline-secondary" href="javascript:void(0);" aria-label="{{ _('Previous page') }}" title="{{ _('Previous page') }}" wire:click="previousPage"><x-icon name="caret-left" /></a>
        @endif
        <input type="text" class="form-control text-center" name="paginator-{{ $paginator->getPageName() }}" wire:model="{{ $paginator->getPageName() }}" value="{{ $paginator->currentPage() }}" wire:key="paginator-{{ $paginator->getPageName() }}-input" aria-label="Example text with two button addons">
        @if ($paginator->currentPage() === $paginator->lastPage())
            <button class="btn btn-outline-secondary" type="button" disabled><x-icon name="caret-right" /></button>
            <button class="btn btn-outline-secondary" type="button" disabled><x-icon name="forward-step" /></button>
        @else
            <button class="btn btn-outline-secondary" type="button" title="{{ _('Next page') }}" wire:click="nextPage"><x-icon name="caret-right" /></button>
            <button class="btn btn-outline-secondary" type="button" title="{{ _('Last page') }}" wire:click="gotoPage({{ $paginator->lastPage() }})"><x-icon name="forward-step" /></button>
        @endif
    </div>
</nav>
