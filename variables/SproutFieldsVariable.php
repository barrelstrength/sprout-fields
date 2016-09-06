<?php
namespace Craft;

class SproutFieldsVariable
{
	public function obfuscateEmailAddresses($options)
	{
		return craft()->sproutFields_emailSelectField->obfuscateEmailAddresses($options);
	}
}
