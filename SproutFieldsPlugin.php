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
		Craft::import('plugins.sproutfields.contracts.SproutFieldsSproutFormsBaseField');
	}


	/**
	 * Register a Sprout Field for support in dynamic forms
	 *
	 * @return string  Name of FieldType
	 */
	public function registerSproutFormsFields()
	{
		return array(
			new SproutFields_Phone(),
			new SproutFields_Link(),
			new SproutFields_Email(),
			new SproutFields_Address()
		);
	}

	public function registerCpRoutes()
	{

		return array(
			'sproutaddressfield/form' => array(
				'action' => 'sproutFields/sproutAddress'
			)
		);
	}
}
