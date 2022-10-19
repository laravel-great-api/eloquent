<?php

namespace LaravelGreatApi\Eloquent\Traits;

trait HasStore
{
    public function scopeStore($query, $data, $relation = null)
    {
        return new ($this->store)($this, $data, $relation);
    }
}
