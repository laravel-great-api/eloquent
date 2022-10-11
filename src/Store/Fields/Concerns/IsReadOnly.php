<?php

namespace LaravelGreatApi\Eloquent\Store\Fields\Concerns;

use Closure;
use Illuminate\Http\Request;
use InvalidArgumentException;
use LaravelGreatApi\Eloquent\Store\Repositories\RepositoryCreate;
use LaravelGreatApi\Eloquent\Store\Repositories\RepositoryUpdate;

trait IsReadOnly
{
    /**
     * Whether the field is read-only.
     *
     * @var Closure|bool
     */
    private $readOnly = false;

    /**
     * Mark the field as read-only.
     *
     * @param Closure|bool $callback
     * @return $this
     */
    public function readOnly($callback = true): self
    {
        if (!is_bool($callback) && !$callback instanceof Closure) {
            throw new InvalidArgumentException('Expecting a boolean or closure.');
        }

        $this->readOnly = $callback;

        return $this;
    }

    /**
     * Mark the field as read only when the resource is being created.
     *
     * @return $this
     */
    public function readOnlyOnCreate(): self
    {
        $this->readOnly(fn() => $this->repository->isCreate());

        return $this;
    }

    /**
     * Mark the field as read only when the resource is being updated.
     *
     * @return $this
     */
    public function readOnlyOnUpdate(): self
    {
        $this->readOnly(fn() => $this->repository->isUpdate());

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function isReadOnly(): bool
    {
        if ($this->readOnly instanceof Closure) {
            return true === ($this->readOnly)();
        }

        return $this->readOnly;
    }

    /**
     * @inheritDoc
     */
    public function isNotReadOnly(): bool
    {
        return !$this->isReadOnly();
    }
}
