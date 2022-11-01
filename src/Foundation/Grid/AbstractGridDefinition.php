<?php

namespace SDLX\Core\Foundation\Grid;

use Livewire\Component;
use Livewire\WithPagination;
use SDLX\Core\Foundation\Database\Model;
use SDLX\Core\Framework\Grid\Columns\Column;

/**
 * Abstract Grid Definition that every Grid should implement
 */
abstract class AbstractGridDefinition extends Component
{
    use WithPagination;

    /**
     * @var int Records per page to show
     */
    public int $per_page = 25;

    /**
     * @var string|null Column name by which to sort the data
     */
    public ?string $sort_by = null;

    /**
     * @var bool|null Sort data in descending order
     */
    public ?bool $sort_desc = null;

    /**
     * @var array An array with active filter data
     */
    public array $active_filters = [];

    /**
     * @var Column[] Column array
     */
    protected array $columns;

    /**
     * @var FilterInterface[] Available grid filters
     */
    protected array $filters;

    protected static string $model;

    /**
     * URI query parameters that should be pushed to the browser location each time they change
     *
     * @var string[]
     */
    protected $queryString = [
        'sort_by',
        'sort_desc',
        'per_page',
    ];

    protected $paginationTheme = 'bootstrap';

    /**
     * Get columns array
     *
     * @return Column[]
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * Sort data by column name
     *
     * @param string $column
     * @return $this
     */
    public function sortBy(string $column): self
    {
        if ($this->sort_by === $column) {
            // Invert direction
            $this->sort_desc = !$this->sort_desc;
        } else {
            // Reset to ascending
            $this->sort_desc = false;
        }

        $this->sort_by = $column;

        return $this;
    }

    /**
     * Is the data currently sorted by the specified column?
     *
     * @param string $column
     * @return bool
     */
    public function isSortedBy(string $column): bool
    {
        return $this->sort_by === $column;
    }

    /**
     * Is the data currently sorted in descending order?
     *
     * @return bool
     */
    public function isSortedDesc(): bool
    {
        return $this->sort_desc;
    }

    /**
     * Get grid filters
     *
     * @return FilterInterface[]
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    /**
     * Does the grid have any filters?
     *
     * @return bool
     */
    public function hasFilters(): bool
    {
        return ! empty($this->filters);
    }

    /**
     * Construct and return an unique filter key that is used in the wire:key attribute
     *
     * @param FilterInterface $filter
     * @return string
     */
    public function getFilterKey(FilterInterface $filter): string
    {
        return md5(static::class . 'filter' . $filter->getName());
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        /** @var Model $model */
        $model = static::$model;

        $query = $model::query();

        if ($this->sort_by) {
            $query->orderBy($this->sort_by, $this->sort_desc ? 'desc' : 'asc');
        }

        foreach ($this->filters as $filter) {
            $filter->apply($query, trim($this->active_filters[$filter->getName()] ?? null));
        }

        return view('core::components.grid.grid', [
            'objects' => $query->paginate($this->per_page, ['*'], 'page', $this->page),
        ]);
    }

    /**
     * Get options for the "records per page" selector.<br/>
     * Grid implementations can overload this method to provide their own options.
     *
     * @return int[]
     */
    public function getPaginationOptions(): array
    {
        return [
            10 => 10,
            25 => 25,
            50 => 50,
            100 => 100,
            1000 => 1000,
        ];
    }

    public function paginationView()
    {
        return 'core::components.grid.pagination';
    }

    public function updating($name, $value)
    {
        switch ($name) {
            case 'page':
                $this->setPage($value);
                break;
            case 'per_page':
                $this->resetPage();
                break;
        }
    }

}
