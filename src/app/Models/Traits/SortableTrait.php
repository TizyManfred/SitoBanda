<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * Trait SortableTrait
 * @package App\Models\Traits
 */
trait SortableTrait
{
    /**
     * Boot the sortable trait for a model.
     *
     * @return void
     */
    protected static function bootSortableTrait(): void
    {
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('sort_order', 'asc');
        });
    }

    /**
     * Scope a query to only include models in display order.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order', 'asc');
    }
}
