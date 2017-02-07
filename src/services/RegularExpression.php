<?php
namespace barrelstrength\sproutfields\services;

use Craft;
use yii\base\Component;

use barrelstrength\sproutfields\SproutFields;
/**
 * Class PhoneService
 *
 */
class RegularExpression extends Component
{

	/**
	 *
	 * @param $value
	 * @param $field
	 *
	 * @return bool
	 */
	public function validate($value, $field): bool
	{
		$customPattern = $field->customPattern;

		if (!empty($customPattern))
		{
			// Use backticks as delimiters
			$customPattern = "`" . $customPattern . "`";

			if (!preg_match($customPattern, $value))
			{
				return false;
			}
		}

		return true;
	}

	/**
	 * Return error message
	 *
	 * @param  mixed  $field
	 *
	 * @return string
	 */
	public function getErrorMessage($field): string
	{
		if (!empty($field->customPattern) && isset($field->customPatternErrorMessage))
		{
			return SproutFields::t($field->customPatternErrorMessage);
		}

		return SproutFields::t($field->name . ' must be a valid pattern.');
	}

}
