<?php

namespace LaravelGreatApi\Eloquent\Store\Fields\Abstraction;

use Closure;

/**
 * @method string guessColumn
 */
class Relation
{
	protected $relationName;

	protected $column;

	private $fillable = true;

	public function __construct($relationName, $column = null)
	{
		$this->relationName = $relationName;

		$this->column = $column ?? $this->getGuessColumn();
	}

	private function getGuessColumn()
	{
		if (method_exists($this, 'guessColumn')) {
			return $this->guessColumn();
		}

		return null;
	}

	public function getRelationName()
	{
		return $this->relationName;
	}

	public function getColumn()
	{
		return $this->column;
	}

	public function column()
	{
		return $this->column;
	}

	public function relation()
	{
		return $this->relationName;
	}

	/**
	 * Undocumented function
	 *
	 * @param Closure|boolean $condition
	 * @return $this
	 */
	public function fillable(Closure|bool $condition)
	{
		if ($condition instanceof Closure) {
			$this->fillable = $condition();
		} else {
			$this->fillable = $condition;
		}

		return $this;
	}

	public function isFillable()
	{
		return $this->fillable;
	}
}
