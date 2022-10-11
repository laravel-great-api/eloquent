<?php

namespace LaravelGreatApi\Eloquent\Store\Repositories;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use LaravelGreatApi\Eloquent\Store\Concerns\HasStore;
use LaravelGreatApi\Eloquent\Store\Contracts\Fields\RelationToMany;
use LaravelGreatApi\Eloquent\Store\FieldFiller;
use LaravelGreatApi\Eloquent\Store\Fields\Abstraction\Attribute as AttributeField;
use LaravelGreatApi\Eloquent\Store\Store;
use LaravelGreatApi\Helpers\Data;
use LaravelGreatApi\Eloquent\Store\Observer;
use LaravelGreatApi\Eloquent\Store\RelationManager;
use LaravelGreatApi\Eloquent\Store\Contracts\Fields\RelationToOne;
use LaravelGreatApi\Eloquent\Store\Fields\NewField;

/**
 * @method $this registerStore
 */
class Repository
{
	use HasStore;

	/**
	 * Undocumented variable
	 *
	 * @var Data
	 */
	protected Data $data;

	/**
	 * Request
	 *
	 * @var Request
	 */
	private Request $request;

	/**
	 * Model
	 *
	 * @var Model
	 */
	protected Model $model;

	/**
	 * Observer
	 *
	 * @var Observer
	 */
	private Observer $observer;

	/**
	 * Saving State
	 *
	 * @var boolean|null
	 */
	private ?bool $saved = null;

	/**
	 * Undocumented function
	 *
	 * @param Model $model
	 * @return $this
	 */
	public function setModel(Model $model)
	{
		$this->model = $model;

		return $this;
	}

	/**
	 * Undocumented function
	 *
	 * @param Model $model
	 * @return $this
	 */
	public function setData(Data $data)
	{
		$this->data = $data;

		return $this;
	}

	/**
	 * Undocumented function
	 *
	 * @param Observer $observer
	 * @return $this
	 */
	public function registerObserver(Observer $observer)
	{
		$this->observer = $observer;

		return $this;
	}

	/**
	 * Undocumented function
	 *
	 * @return Store
	 */
	public function getStore()
	{
		return $this->store;
	}

	/**
	 * Undocumented function
	 *
	 * @return Data
	 */
	public function getData()
	{
		return $this->data;
	}

	/**
	 * Undocumented function
	 *
	 * @param Closure $callback
	 * @return void
	 */
	private function eachFields(Closure $callback)
	{
		foreach($this->store->fields(new NewField(), $this->getData()) as $field) {
			$callback($field);
		}
	}

	/**
	 * Undocumented function
	 *
	 * @param Closure $callback
	 * @return void
	 */
	private function eachAttributes(Closure $callback)
	{
		$this->eachFields(function($field) use($callback) {
			if ($field instanceof AttributeField) {
				$callback($field->registerRepository($this));
			}
		});
	}

	/**
	 * Undocumented function
	 *
	 * @param Closure $callback
	 * @return void
	 */
	private function eachFiller(Closure $callback): void
	{
		$this->eachAttributes(function($field) use($callback) {
			$callback(new FieldFiller($field, $this->data, $this->model));
		});
	}

	/**
	 * Undocumented function
	 *
	 * @param FieldFiller $fieldFiller
	 * @return void
	 */
	private function fillField(FieldFiller $fieldFiller)
	{
		$fieldFiller->fill();
	}

	/**
	 * Undocumented function
	 *
	 * @param [type] $field
	 * @return RelationManager
	 */
	private function relationManager($field): RelationManager
	{
		return new RelationManager(
			$field,
			$this->getData(),
			$this->getModel(),
			$this
		);
	}

	/**
	 * Undocumented function
	 *
	 * @param Closure $callback
	 * @return void
	 */
	private function eachRelationsToOne(Closure $callback)
	{
		$this->eachFields(function($field) use($callback) {
			if ($field instanceof RelationToOne) {
				$callback($this->relationManager($field));
			}
		});
	}

	/**
	 * Undocumented function
	 *
	 * @param Closure $callback
	 * @return void
	 */
	private function eachRelationsToMany(Closure $callback)
	{
		$this->eachFields(function($field) use($callback) {
			if ($field instanceof RelationToMany && $field->isFillable()) {
				$callback($this->relationManager($field));
			}
		});
	}

	/**
	 * Undocumented function
	 *
	 * @return $this
	 */
	private function fill(): self
	{
		$this->eachFiller(fn(FieldFiller $fieldFiller) => $this->fillField($fieldFiller));

		$this->eachRelationsToOne(function(RelationManager $relationManager) {
			if ($this->isCreate()) {
				$relationManager->create();
			}

			if ($this->isUpdate()) {
				$relationManager->update();
			}
		});

		return $this;
	}

	/**
	 * Undocumented function
	 *
	 * @return $this
	 */
	private function filled()
	{
		$this->observer->dispatch('beforeSave');

		return $this;
	}

	/**
	 * Undocumented function
	 *
	 * @return Model
	 */
	public function getModel(): Model
	{
		return $this->model;
	}

	/**
	 * Undocumented function
	 *
	 * @return Bool
	 */
	public function isModelExists(): Bool
	{
		return $this->model->exists;
	}

	/**
	 * Undocumented function
	 *
	 * @return boolean
	 */
	public function isSaving(): bool
	{
		return $this->saved === null;
	}

	/**
	 * Undocumented function
	 *
	 * @return boolean
	 */
	public function isSaved(): bool
	{
		return $this->saved === true;
	}

	/**
	 * Undocumented function
	 *
	 * @return boolean
	 */
	public function isCreate(): bool
	{
		return $this instanceof RepositoryCreate;
	}

	/**
	 * Undocumented function
	 *
	 * @return boolean
	 */
	public function isCreated(): bool
	{
		return $this->isSaved() && $this->isCreate();
	}

	/**
	 * Undocumented function
	 *
	 * @return boolean
	 */
	public function isUpdate(): bool
	{
		return $this instanceof RepositoryUpdate;
	}

	/**
	 * Undocumented function
	 *
	 * @return boolean
	 */
	public function isUpdated(): bool
	{
		return $this->isSaved() && $this->isUpdate();
	}

	/**
	 * Undocumented function
	 *
	 * @return Model
	 */
	private function save(): Model
	{
		$this->saved = $this->model->save();

		$this->observer->dispatch('afterSave');

		if ($this->store->isRelation()) {
			$this->store->getRelation()->attach($this->model, [], true);
		}

		$this->eachRelationsToMany(fn(RelationManager $relationManager) => $relationManager->create());

		return $this->model;
	}

	/**
	 * Undocumented function
	 *
	 * @return Model
	 */
	public function store()
	{
		return DB::transaction(
			fn() => $this->fill()->filled()->save()
		);
	}
}
