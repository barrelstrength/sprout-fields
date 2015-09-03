<?php
namespace Craft;

class SproutFieldsPlugin extends BasePlugin
{
	public function getName()
	{
		return 'Sprout Fields';
	}

	public function getVersion()
	{
		return '1.0.0';
	}

	public function getDeveloper()
	{
		return 'Barrel Strength Design';
	}

	public function getDeveloperUrl()
	{
		return 'http://barrelstrengthdesign.com';
	}

	/**
	 * Register a Sprout Field for support in dynamic forms
	 * 
	 * @return string  Name of FieldType
	 */
	public function registerSproutField()
	{
		//return 'SproutPhoneField_Phone';
		//return 'SproutLinkField_Phone';
		return 'SproutEmailField_Email';
	}
}
