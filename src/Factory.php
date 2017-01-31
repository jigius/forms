<?php

namespace jigius\forms;

class Factory implements FactoryInterface
{
	public static function getFieldFactory()
	{
		return "jigius\\forms\\Field\\FieldFactory";
	}

	public static function getFilterFactory()
	{
		return "jigius\\forms\\Filter\\FilterFactory";
	}

	public static function getValidatorFactory()
	{
		return "jigius\\forms\\Validator\\ValidatorFactory";
	}
}
