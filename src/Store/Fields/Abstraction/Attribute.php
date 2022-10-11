<?php

namespace LaravelGreatApi\Eloquent\Store\Fields\Abstraction;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use LaravelGreatApi\Eloquent\Store\Fields\Concerns\IsReadOnly;
use LaravelGreatApi\Eloquent\Store\Repositories\Repository;

/**
 * Undocumented class
 * 
 * @method mixed defineDefaultValue
 */
abstract class Attribute
{
	use IsReadOnly;

    /**
     * @var Closure|null
     */
    private ?Closure $deserializer = null;

	/**
	 * Undocumented variable
	 *
	 * @var mixed
	 */
	private $defaultValue = null;

	/**
	 * Undocumented variable
	 *
	 * @var Repository
	 */
	private Repository $repository;

	/**
	 * Attribute Constructor
	 *
	 * @param string $fieldName
	 * @param string|null $column
	 */
	public function __construct(string $fieldName, string $column = null)
	{
		$this->name = $fieldName;
		$this->column = $column ?? $this->guessColumn();
	}

    /**
     * Assert that the attribute JSON value is as expected.
     *
     * @param $value
     * @return void
     */
    abstract protected function assertValue($value): void;

	/**
	 * Get Field Name
	 *
	 * @return string
	 */
    public function name(): string
    {
        return $this->name;
    }

	/**
	 * Get Serialized Field Name
	 *
	 * @return string
	 */
    public function serializedFieldName(): string
    {
        return $this->name();
    }

	/**
	 * Guess Column
	 *
	 * @return string
	 */
    private function guessColumn(): string
    {
        return $this->name();
    }

	/**
	 * Get Column Name
	 *
	 * @return string
	 */
    public function column(): string
    {
        return $this->column;
    }

	/**
	 * Fill
	 *
	 * @param Model $model
	 * @param mixed $value
	 * @return void
	 */
	public function fill(Model $model, mixed $value)
	{
		$column = $this->column();

		$model->{$column} = $this->deserialize($value);
	}

    /**
     * Customise deserialization of the value.
     *
     * @param Closure $deserializer
     * @return $this
     */
    public function deserializeUsing(Closure $deserializer): self
    {
        $this->deserializer = $deserializer;

        return $this;
    }

    /**
     * Convert the JSON value for this field.
     *
     * @param mixed $value
     * @return mixed
     */
    protected function deserialize($value)
    {
        $this->assertValue($value);

        if ($this->deserializer) {
            return ($this->deserializer)($value);
        }

        return $value;
    }

	/**
	 * Default Value Is Not Exists
	 *
	 * @return boolean
	 */
	public function defaultValueIsNotExists(): bool
	{
		return $this->defaultValue === null;
	}

	/**
	 * Undocumented function
	 *
	 * @return boolean
	 */
	public function isDefinedDefaultValue()
	{
		return method_exists($this, 'defineDefaultValue');
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function getDefindedDefaultValue()
	{
		return $this->defineDefaultValue();
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function defaultValueExists()
	{
		return $this->defaultValue != null || $this->isDefinedDefaultValue();
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function getDefaultValue()
	{
		if ($this->isDefinedDefaultValue()) {
			return $this->getDefindedDefaultValue();
		}

		return $this->defaultValue;
	}

	/**
	 * Set Default Value
	 *
	 * @param [type] $callback
	 * @return void
	 */
	public function default($callback)
	{
		$value = $callback instanceof Closure ? $callback() : $callback;

		$this->assertValue($value);

		$this->defaultValue = $value;

		return $this;
	}

	/**
	 * Undocumented function
	 *
	 * @param Repository $repository
	 * @return $this
	 */
	public function registerRepository(Repository $repository)
	{
		$this->repository = $repository;

		return $this;
	}
}
