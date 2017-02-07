<?php
namespace barrelstrength\sproutfields\services;

use Craft;
use craft\base\Component;

class Utilities extends Component
{
	/**
	 * Returns current Field Type context to properly get field settings
	 *
	 * @param $field Email Field Object
	 * @param $element
	 *
	 * @return string
	 */
	public function getFieldContext($field, $element)
	{
		$context = 'global';

		if ($field->context)
		{
			$context = $field->context;
		}

		if ($element)
		{
			$context = $element->getFieldContext();
		}

		return $context;
	}

	public function isAnyOptionsSelected($options, $value = null)
	{
		if (!empty($options))
		{
			foreach ($options as $option)
			{
				if ($option->selected == true || ($value != null && $value == $option->value))
				{
					return true;
				}
			}
		}

		return false;
	}
}

