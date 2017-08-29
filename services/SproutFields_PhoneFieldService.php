<?php
namespace Craft;

/**
 * Class SproutFields_PhoneFieldService
 *
 * @package Craft
 */
class SproutFields_PhoneFieldService extends BaseApplicationComponent
{
	/**
	 * @var string
	 */
	protected $mask;

	/**
	 * @return string
	 */
	public function getDefaultMask()
	{
		return "##########";
	}

	/**
	 * Validates a phone number against a given mask/pattern
	 *
	 * @param $value
	 * @param $mask
	 *
	 * @return bool
	 */
	public function validate($value, $mask)
	{
		if ($value == $mask)
		{
			return true;
		}

		$mask = preg_quote($mask);

		$phonePattern = $this->convertMaskToRegEx($mask);

		if (preg_match($phonePattern, $value))
		{
			return true;
		}

		return false;
	}

	/**
	 * Converts a pattern mask into a regular expression
	 *
	 * @param $mask
	 *
	 * @return string
	 */
	public function convertMaskToRegEx($mask)
	{
		$this->mask = $mask;

		$hashPatterns = $this->prepareHashesForRegEx();

		return $this->getRegEx($hashPatterns);
	}

	/**
	 * Prepare mask info to be converted to regular expressions
	 *
	 * @return array
	 */
	protected function prepareHashesForRegEx()
	{
		$mask = $this->mask;

		// Explode hashes
		preg_match_all("/#*/", $mask, $matches);

		// Remove empty array values
		$hashes = array_values(array_filter($matches[0]));

		// Organize for regex replacement
		if ($hashes)
		{
			$i            = 0;
			$hashPatterns = array();

			foreach ($hashes as $hash)
			{
				$length = strlen($hash);

				$hashPatterns[$i]['pattern']      = "([0-9]{" . $length . "})";
				$hashPatterns[$i]['hash']         = $hash;
				$hashPatterns[$i]['preg_replace'] = "([#]{" . $length . "})";

				$i++;
			}

			return $hashPatterns;
		}
	}

	/**
	 * Processes mask info and returns a regular expression
	 *
	 * @param $hashPatterns
	 *
	 * @return string
	 */
	protected function getRegEx($hashPatterns)
	{
		$mask = $this->mask;

		if ($hashPatterns)
		{
			foreach ($hashPatterns as $hashPattern)
			{
				$pattern      = $hashPattern['pattern'];
				$preg_replace = $hashPattern['preg_replace'];

				// Add fourth parameter for non-greedy matching
				$mask = preg_replace($preg_replace, $pattern, $mask, 1);
			}

			$regEx = '/^' . $mask . '$/';

			return $regEx;
		}
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
		// Change empty condition to show default message when toggle settings is unchecked
		if (!empty($settings['customPatternErrorMessage']))
		{
			return Craft::t($settings['customPatternErrorMessage']);
		}

		$vars = array('field' => $fieldName, 'format' => $settings['mask']);

		return Craft::t('{field} is invalid. Required format: {format}', $vars);
	}

}
