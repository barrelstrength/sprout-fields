<?php
namespace Craft;

/**
 * Class SproutFields_LinkFieldService
 *
 * @package Craft
 */
class SproutFields_LinkFieldService extends BaseApplicationComponent
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
		$checkPattern  = $field->settings['customPatternToggle'];

		if ($customPattern && $checkPattern)
		{
			// Use backticks as delimiters as they are invalid characters for emails
			$customPattern = "`" . $customPattern . "`";

			if (preg_match($customPattern, $value))
			{
				return true;
			}
		}
		else
		{
			if ((!filter_var($value, FILTER_VALIDATE_URL) === false))
			{
				return true;
			}
		}

		return false;
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

		return Craft::t($fieldName . ' must be a valid link.');
	}
}
