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
			new PhoneField(),
			new LinkField(),
			new EmailField(),
		);
	}

	/**
	 * User for address front end integration
	 * @return array
	 */
	public function registerCpRoutes()
	{

		return array(
			'sproutaddressfield/form' => array(
				'action' => 'sproutFields/sproutAddress'
			)
		);
	}
}

/**
 * @return SproutFieldsService
 */
function sproutFields()
{
	return Craft::app()->getComponent('sproutForms');
}
