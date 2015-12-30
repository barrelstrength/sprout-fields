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

		craft()->on('sproutForms.beforePopulateEntry', array(sproutFields()->emailSelect, 'handleUnobfuscateEmailAddresses'));
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
	public function getDescription()
	{
		return 'Powerful fields. Cleaner data.';
	}

	/**
	 * @return string
	 */
	public function getVersion()
	{
		return '2.0.1';
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
	 * @return string
	 */
	public function getDocumentationUrl()
	{
		return "http://sprout.barrelstrengthdesign.com/craft-plugins/fields/docs";
	}

	/**
	 * @return string
	 */
	public function getReleaseFeedUrl()
	{
		return 'https://sprout.barrelstrengthdesign.com/craft-plugins/fields/releases.json';
	}

	/**
	 * @return array
	 */
	protected function defineSettings()
	{
		return array(
			'infoPrimaryDocumentation'      => AttributeType::String,
			'infoSecondaryDocumentation'    => AttributeType::String,
			'warningDocumentation'          => AttributeType::String,
			'dangerDocumentation'           => AttributeType::String,
			'highlightDocumentation'        => AttributeType::String
		);
	}


	public function getSettingsHtml()
	{
		return craft()->templates->render('sproutfields/_cp/settings', array(
			'settings' => $this->getSettings()
		));
	}

	/**
	 * @return array
	 */
	public function registerSproutFormsFields()
	{
		return array(
			new SproutFieldsEmailField(),
			new SproutFieldsEmailSelectField(),
			new SproutFieldsHiddenField(),
			new SproutFieldsInvisibleField(),
			new SproutFieldsLinkField(),
			new SproutFieldsPhoneField(),
			new SproutFieldsNotesField()
		);
	}

	public function onAfterInstall()
	{
		Craft::import('plugins.sproutfields.helpers.SproutFieldsInstallHelper');

		$helper = new SproutFieldsInstallHelper();
		$helper->migrateSproutFields();
		$helper->installDefaultNotesStyles();
	}
}

/**
 * @return SproutFieldsService
 */
function sproutFields()
{
	return Craft::app()->getComponent('sproutFields');
}
