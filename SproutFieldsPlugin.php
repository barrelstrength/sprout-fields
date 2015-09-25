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

	public function init()
	{
		Craft::import('plugins.sproutfields.integrations.sproutforms.fields.*');
		//Craft::import('plugins.sprouttokens.integrations.sprouttokens.*');
	}

//	/**
//	 * Register a Sprout Field for support in dynamic forms
//	 *
//	 * @return string  Name of FieldType
//	 */
	public function registerSproutField()
	{
		//return 'SproutPhoneField_Phone';
		//return 'SproutLinkField_Phone';
		return array('SproutFields_Phone', 'SproutFields_Email', 'SproutFields_Link');
	}
}
