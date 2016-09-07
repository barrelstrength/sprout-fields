<?php
namespace Craft;

class SproutFieldsVariable
{
	public function obfuscateEmailAddresses($options)
	{
		return sproutFields()->emailSelect->obfuscateEmailAddresses($options);
	}
}
