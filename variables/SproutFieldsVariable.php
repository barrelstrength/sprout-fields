<?php
namespace Craft;

class SproutFieldsVariable
{
	/**
	 * @param      $options
	 * @param null $value
	 *
	 * @return mixed
	 */
	public function obfuscateEmailAddresses($options, $value = null)
	{
		return sproutFields()->emailSelect->obfuscateEmailAddresses($options, $value);
	}
}
