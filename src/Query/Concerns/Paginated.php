<?php

namespace LaravelGreatApi\Eloquent\Query\Concerns;

trait Paginated
{
	/**
	 * Limit
	 *
	 * @var integer|null
	 */
    private ?int $limit = 15;

    /**
     * Paginated
     *
     * @param integer|null $limit
     * @return $this
     */
    public function paginated(?int $limit = 15)
    {
        $this->limit = $limit;

        return $this;
    }

	/**
	 * Undocumented function
	 *
	 * @return boolean
	 */
	public function isPaginated(): bool
	{
		return (bool) $this->limit;
	}

	/**
	 * Undocumented function
	 *
	 * @return integer|null
	 */
	public function getLimit(): ?int
	{
		return $this->limit;
	}
}
