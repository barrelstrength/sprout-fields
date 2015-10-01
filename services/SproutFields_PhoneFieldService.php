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
		return "###-###-####";
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
	protected function convertMaskToRegEx($mask)
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
				$len = strlen($hash);

				$hashPatterns[$i]['pattern']      = "([0-9]{".$len."})";
				$hashPatterns[$i]['hash']         = $hash;
				$hashPatterns[$i]['preg_replace'] = "([#]{".$len."})";

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
			$mask = preg_quote($mask);

			foreach ($hashPatterns as $hashPattern)
			{
				$pattern      = $hashPattern['pattern'];
				$preg_replace = $hashPattern['preg_replace'];

				// Add fourth parameter for non-greedy matching
				$mask = preg_replace($preg_replace, $pattern, $mask, 1);
			}
			$regEx = '/^'.$mask.'$/';

			return $regEx;
		}
	}
}
