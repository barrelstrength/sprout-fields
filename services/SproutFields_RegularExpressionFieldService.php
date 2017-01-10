<?php
namespace Craft;

/**
 * Class SproutFields_LinkFieldService
 *
 * @package Craft
 */
class SproutFields_RegularExpressionFieldService extends BaseApplicationComponent
{
	/**
	 * @param $value
	 * @param $field
	 *
	 * @return bool
	 */
	public function validate($value, $field)
	{
		$customPattern = $field->settings['customPattern'];

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
	 * @param  string $fieldName
	 * @param  array  $settings
	 *
	 * @return string
	 */
	public function getErrorMessage($fieldName, $settings)
	{
		if (!empty($settings['customPattern']) && isset($settings['customPatternErrorMessage']))
		{
			return Craft::t($settings['customPatternErrorMessage']);
		}

		return Craft::t($fieldName . ' must be a valid pattern.');
	}
}
