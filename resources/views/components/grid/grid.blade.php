<div class="datagrid">
    @php
        use SDLX\Core\Framework\Grid\Filters\BooleanFilter;
        use SDLX\Core\Framework\Grid\Filters\SearchFilter;
    @endphp
    @if ($this->hasFilters())
        <div class="card filters mb-3">
            <div class="card-header">{{ _('Filters') }}</div>
            <div class="card-body">
                @foreach ($this->getFilters() as $filter)
                    @switch (get_class($filter))
                        @case (BooleanFilter::class)
                            <x-form::switcher :name="$filter->getName()" :label="$filter->getLabel()" :wire:model="$filter->getModelName()" wire:key="{{ $this->getFilterKey($filter) }}"/>
                            @break
                        @case (SearchFilter::class)
                            <x-form::input :name="$filter->getName()" :label="$filter->getLabel()" placeholder="{{ _('Enter keywords here') }}" :wire:model.debounce.500ms="$filter->getModelName()"  wire:key="{{ $this->getFilterKey($filter) }}"/>
                            @break
                    @endswitch
                @endforeach
            </div>
        </div>
    @endif
    <table class="table table-striped">
        <thead>
        <tr>
            @foreach($this->getColumns() as $col)
                <th style="@if ($col->getWidth()) width: {{ $col->getWidth() }}px @endif">
                    @if ($col->isSortable())
                        <span class="column-sort" wire:click="sortBy('{{ $col->getAccessor()  }}')">
                                {{ $col->getLabel() }}
                            @if ($this->isSortedBy($col->getAccessor()))
                                <span class="column-sort-dir">
                                        @if ($this->isSortedDesc())
                                        <x-icon name="chevron-down"/>
                                    @else
                                        <x-icon name="chevron-up"/>
                                    @endif
                                    </span>
                            @endif
                            </span>
                    @else
                        {{ $col->getLabel() }}
                    @endif
                </th>
            @endforeach
        </tr>
        </thead>
        <tbody>
            @foreach ($objects as $object)
                <tr>
                    @foreach ($this->getColumns() as $col)
                        <td>{!! $col->render($object) !!}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="{{ count($this->getColumns()) }}">
                    {{ $objects->links() }}
                    <x-form::select name="per_page" :options="$this->getPaginationOptions()" :default="$this->per_page" wire:model="per_page" :placeholder="false" :label="_('Records per page') . ':'" size="sm" class="grid-per-page"/>
                </td>
            </tr>
        </tfoot>
    </table>
</div>
