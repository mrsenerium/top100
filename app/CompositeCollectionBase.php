<?php

namespace App;

use Illuminate\Database\Eloquent\Collection as Collection;
use Illuminate\Support\Arr;

class CompositeCollectionBase extends Collection
{
    /**
     * Find a model in the collection by second composite key.
     *
     * @param  mixed  $key
     * @param  mixed  $default
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findBySecondary($key, $default = null)
    {
        if ($key instanceof Model) {
            $key = $key->getKey('secondary');
        }
        return Arr::first($this->items, function ($itemKey, $model) use ($key) {
            return $model->getKey('secondary') == $key;

        }, $default);
    }
}
