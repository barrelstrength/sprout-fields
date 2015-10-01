<?php
namespace Craft;

/**
 * Class SproutFieldsPlugin
 *
 * @package Craft
 */
class SproutFieldsPlugin extends BasePlugin
{
	public function init()
	{
		Craft::import('plugins.sproutfields.contracts.SproutFieldsBaseField');
		Craft::import('plugins.sproutfields.integrations.sproutforms.fields.*');
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'Sprout Fields';
	}

	/**
	 * @return string
	 */
	public function getVersion()
	{
		return '1.0.0';
	}

	/**
	 * @return string
	 */
	public function getDeveloper()
	{
		return 'Barrel Strength Design';
	}

	/**
	 * @return string
	 */
	public function getDeveloperUrl()
	{
		return 'http://barrelstrengthdesign.com';
	}

	/**
	 * @return array
	 */
	public function registerSproutFormsFields()
	{
		return array(
			new SproutFieldsPhoneField(),
			new SproutFieldsLinkField(),
			new SproutFieldsEmailField(),
		);
	}
}

/**
 * @return SproutFieldsService
 */
function sproutFields()
{
	return Craft::app()->getComponent('sproutFields');
}
