<?php

namespace LaravelGreatApi\Eloquent\Resource\Attributes;

class Number extends Attribute
{
	public function assertValue($value)
	{
		return intval($value);
	}
}
