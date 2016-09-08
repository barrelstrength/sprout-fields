<?php
namespace Craft;

class SproutFieldsVariable
{
	public function obfuscateEmailAddresses($options, $value = null)
	{
		return sproutFields()->emailSelect->obfuscateEmailAddresses($options, $value);
	}
}
