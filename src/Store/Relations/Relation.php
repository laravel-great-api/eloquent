<?php

namespace LaravelGreatApi\Eloquent\Store\Relations;

/**
 * @method mixed create($model, $data)
 * @method mixed update($model, $data)
 * @method mixed store()
 * @property string $store
 */
class Relation
{
    public function key()
    {
        return $this->key;
    }

    public function column()
    {
        return $this->column;
    }

    protected function getStore(): string
    {
        if (method_exists($this, 'store')) {
            return $this->store();
        }

        return static::$store;
    }
}
