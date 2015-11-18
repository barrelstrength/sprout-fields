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
	 * @param string     $value
	 * @param int        $elementId
	 * @param FieldModel $field
	 *
	 * @return bool
	 */
	public function validate($value, $elementId, $field)
	{
		$customPattern = $field->settings['customPattern'];
		$checkPattern  = $field->settings['customPatternToggle'];

		if (!$this->validateEmailAddress($value, $customPattern, $checkPattern))
		{
			return false;
		}

		if ($field->settings['uniqueEmail'] && !$this->validateUniqueEmailAddress($value, $elementId, $field))
		{
			return false;
		}

		return true;
	}

	/**
	 * @param $value         string current email to validate
	 * @param $customPattern string regular expression
	 * @param $checkPattern  bool
	 *
	 * @return bool
	 */
	public function validateEmailAddress($value, $customPattern, $checkPattern = false)
	{
		if ($checkPattern)
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
	 * @param string     $value
	 * @param int        $elementId
	 * @param FieldModel $field
	 *
	 * @return bool
	 */
	public function validateUniqueEmailAddress($value, $elementId, $field)
	{
		$element      = craft()->elements->getElementById($elementId);
		$fieldHandle  = $element->fieldColumnPrefix.$field->handle;
		$contentTable = $element->contentTable;

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

	/**
	 * @param  string $fieldName
	 * @param  array  $settings
	 *
	 * @return string
	 */
	public function getErrorMessage($fieldName, $settings)
	{
		if (isset($settings['customPattern']) && isset($settings['customPatternErrorMessage']))
		{
			return Craft::t($settings['customPatternErrorMessage']);
		}

		return Craft::t($fieldName.' must be a valid email.');
	}
}
