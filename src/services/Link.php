<?php
namespace barrelstrength\sproutfields\services;

use Craft;
use yii\base\Component;

/**
 * Class PhoneService
 *
 */
class Link extends Component
{
	/**
	 * Validates a phone number against a given mask/pattern
	 *
	 * @param $value
	 * @param $mask
	 *
	 * @return bool
	 */
	public function validate($value, $field): bool
	{
		$customPattern = $field->customPattern;
		$checkPattern  = $field->customPatternToggle;

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
	 * @param  mixed  $field
	 *
	 * @return string
	 */
	public function getErrorMessage($field): string
	{
		if (!empty($field->customPattern) && isset($field->customPatternErrorMessage))
		{
			return Craft::t('sproutFields', $field->customPatternErrorMessage);
		}

		return Craft::t('sproutFields', $field->name . ' must be a valid link.');
	}

}
