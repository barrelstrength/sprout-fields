<?php
namespace Craft;

/**
 * Class SproutFields_EmailFieldService
 *
 * @package Craft
 */
class SproutFields_EmailFieldService extends BaseApplicationComponent
{
	/**
	 * @param $value
	 * @param $element
	 * @param $field
	 *
	 * @return bool|null|string
	 */
	public function validate($value, $element, $field)
	{
		$customPattern = $field->settings['customPattern'];

		if (!$this->validateEmailAddress($value, $customPattern))
		{
			if ($customPattern && $field->settings['customPatternErrorMessage'])
			{
				return Craft::t($field->settings['customPatternErrorMessage']);
			}

			return Craft::t($field->name.' must be a valid email.');
		}

		$uniqueEmail = $field->settings['uniqueEmail'];

		if ($uniqueEmail && !$this->validateUniqueEmailAddress($value, $element, $field))
		{
			return Craft::t($field->name.' must be a unique email.');
		}

		return true;
	}

	/**
	 * @param $value
	 *
	 * @return bool
	 */
	public function validateEmailAddress($value, $customPattern = false)
	{
		if ($customPattern)
		{
			// Use backticks as delimiters as they are invalid characters for emails
			$customPattern = "`".$customPattern."`";

			if (preg_match($customPattern, $value))
			{
				return true;
			}
		}
		else
		{
			if ((!filter_var($value, FILTER_VALIDATE_EMAIL) === false))
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * @param $value
	 * @param $element
	 * @param $field
	 *
	 * @return bool
	 */
	public function validateUniqueEmailAddress($value, $element, $field)
	{
		$fieldHandle  = $element->fieldColumnPrefix.$field->handle;
		$contentTable = $element->contentTable;
		$elementId    = $element->id;

		$emailExists = craft()->db->createCommand()
			->select($fieldHandle)
			->from($contentTable)
			->where(
				array(
					$fieldHandle => $value,
				)
			)
			->andWhere(array('not in', 'elementId', $elementId))
			->queryScalar();

		if ($emailExists)
		{
			return false;
		}

		return true;
	}
}
