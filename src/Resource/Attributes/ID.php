<?php

namespace LaravelGreatApi\Eloquent\Resource\Attributes;

class ID
{
	public static function make()
	{
		return [Attribute::make('id')];
	}
}
