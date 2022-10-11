<?php

namespace LaravelGreatApi\Eloquent\Resource\Attributes;

class Timestamps
{
	public static function make()
	{
		return [
			Attribute::make('created_at'),
			Attribute::make('updated_at'),
		];
	}
}
