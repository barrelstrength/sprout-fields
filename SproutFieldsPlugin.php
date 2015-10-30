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
			new SproutFieldsLinkField(),
			new SproutFieldsEmailField(),
			new SproutFieldsPhoneField(),
			new SproutFieldsHiddenField(),
			new SproutFieldsInvisibleField(),
			new SproutFieldsAddressField()
		);
	}

	public function onAfterInstall()
	{
		Craft::import('plugins.sproutfields.helpers.SproutFieldsInstallHelper');

		$helper = new SproutFieldsInstallHelper();
		$helper->migrateSproutFields();
	}

}

/**
 * @return SproutFieldsService
 */
function sproutFields()
{
	return Craft::app()->getComponent('sproutFields');
}
