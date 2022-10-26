<?php

namespace LaravelGreatApi\Eloquent\Store\Fields;

class Field
{
	public function string(string $fieldName, string $column = null): Str
	{
		return Str::make($fieldName, $column);
	}

	public function number(string $fieldName, string $column = null): Number
	{
		return Number::make($fieldName, $column);
	}

	public function uniqueString(string $fieldName, int $length = 5, string $column = null): UniqueStr
	{
		return UniqueStr::make($fieldName, $length, $column);
	}

	public function array($fieldName, $column = null)
	{
		return Arr::make($fieldName, $column);
	}
}
