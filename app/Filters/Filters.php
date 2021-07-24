<?php


namespace App\Filters;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class Filters
{
    protected Request $request;
    protected Builder $query;
    protected array $filters = [];


    /**
     * ThreadFilters constructor.
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply the given filter.
     * @param Builder $query
     * @return Builder
     */
    public function apply(Builder $query): Builder
    {
        $this->query = $query;

        foreach ($this->getFilters() as $filter => $value) {
           if (method_exists($this, $filter)) {
               $this->$filter($value);
           }
        }
        return $this->query;
    }

    /**
     * Get the filters based on the current request only.
     * @return array
     */
    public function getFilters(): array
    {
        return $this->request->only($this->filters);
    }

}
