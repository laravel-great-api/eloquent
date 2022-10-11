<?php

namespace LaravelGreatApi\Eloquent\Query\Filters;

use Closure;
use LaravelGreatApi\Helpers\Data;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class Builder
{
	/**
	 * Данные из запроса
	 *
	 * @var \LaravelGreatApi\Helpers\Data
	 */
	private Data $data;

	/**
	 * Фильтры определенные в Query классе
	 *
	 * @var array
	 */
	private array $filters;

	/**
	 * Инстанс билдера
	 *
	 * @var \Illuminate\Database\Eloquent\Builder
	 */
	private EloquentBuilder $query;

	/**
	 * Конструктор класса
	 *
	 * @param array $data
	 * @param array $filters
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 */
	public function __construct(array $data, array $filters, EloquentBuilder $query)
	{
		$this->data = new Data($data);
		$this->filters = $filters;
		$this->query = $query;
	}

	/**
	 * Подготовка значения
	 *
	 * @param LaravelGreatApi\Eloquent\Query\Filters\Filter $filter
	 * @param mixed $value
	 * @return mixed
	 */
	private function prepareValue(Filter $filter, mixed $value): mixed
	{
		if ($filter->hasSanitize()) {
			return $filter->sanitize($value);
		}

		return $value;
	}

	/**
	 * Обход доступных фильтров в цикле
	 *
	 * @param Closure $callback
	 * @return void
	 */
	private function eachFilters(Closure $callback)
	{
		foreach($this->filters as $filter) {
			if ($value = $this->data->get($filter->name())) {
				$callback($filter, $this->prepareValue($filter, $value));
			}
		}
	}

	/**
	 * Билдинг запроса
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function build(): EloquentBuilder
	{
		$this->eachFilters(fn(Filter $filter, $value) => $filter->apply($value, $this->query));

		return $this->query;
	}
}
