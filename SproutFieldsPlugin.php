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

		Craft::import('plugins.sproutfields.integrations.sproutforms.fields.SproutFieldsAddressField');
		Craft::import('plugins.sproutfields.integrations.sproutforms.fields.SproutFieldsEmailField');
		Craft::import('plugins.sproutfields.integrations.sproutforms.fields.SproutFieldsEmailSelectField');
		Craft::import('plugins.sproutfields.integrations.sproutforms.fields.SproutFieldsHiddenField');
		Craft::import('plugins.sproutfields.integrations.sproutforms.fields.SproutFieldsInvisibleField');
		Craft::import('plugins.sproutfields.integrations.sproutforms.fields.SproutFieldsLinkField');
		Craft::import('plugins.sproutfields.integrations.sproutforms.fields.SproutFieldsNotesField');
		Craft::import('plugins.sproutfields.integrations.sproutforms.fields.SproutFieldsPhoneField');
		Craft::import('plugins.sproutfields.integrations.sproutforms.fields.SproutFieldsRegularExpressionField');

		Craft::import('plugins.sproutfields.integrations.sproutimport.fields.SproutFields_EmailSproutImportFieldImporter');
		Craft::import('plugins.sproutfields.integrations.sproutimport.fields.SproutFields_EmailSelectSproutImportFieldImporter');
		Craft::import('plugins.sproutfields.integrations.sproutimport.fields.SproutFields_HiddenSproutImportFieldImporter');
		Craft::import('plugins.sproutfields.integrations.sproutimport.fields.SproutFields_InvisibleSproutImportFieldImporter');
		Craft::import('plugins.sproutfields.integrations.sproutimport.fields.SproutFields_LinkSproutImportFieldImporter');
		Craft::import('plugins.sproutfields.integrations.sproutimport.fields.SproutFields_NotesSproutImportFieldImporter');
		Craft::import('plugins.sproutfields.integrations.sproutimport.fields.SproutFields_PhoneSproutImportFieldImporter');

		// This check ensures the yiic command line tool can run
		// @deprecate - Craft 3 may not require this check any longer
		if (!craft()->isConsole())
		{
			craft()->on('sproutForms.beforePopulateEntry', array(sproutFields()->emailSelect, 'handleUnobfuscateEmailAddresses'));
		}
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
		return 'Fabulous fields. Cleaner data.';
	}

	/**
	 * @return string
	 */
	public function getVersion()
	{
		return '2.2.0';
	}

	/**
	 * @return string
	 */
	public function getSchemaVersion()
	{
		return '2.0.3';
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
        return 'https://raw.githubusercontent.com/barrelstrength/craft-sprout-fields/v2/releases.json';
	}

	/**
	 * @return array
	 */
	protected function defineSettings()
	{
		return array(
			'infoPrimaryDocumentation'   => AttributeType::String,
			'infoSecondaryDocumentation' => AttributeType::String,
			'warningDocumentation'       => AttributeType::String,
			'dangerDocumentation'        => AttributeType::String,
			'highlightDocumentation'     => AttributeType::String
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
			new SproutFieldsNotesField(),
			new SproutFieldsRegularExpressionField()
		);
	}

	/**
	 * Sprout Import fake data integration
	 *
	 * @return array
	 */
	public function registerSproutImportImporters()
	{
		return array(
			new SproutFields_EmailSproutImportFieldImporter(),
			new SproutFields_EmailSelectSproutImportFieldImporter(),
			new SproutFields_HiddenSproutImportFieldImporter(),
			new SproutFields_InvisibleSproutImportFieldImporter(),
			new SproutFields_LinkSproutImportFieldImporter(),
			new SproutFields_NotesSproutImportFieldImporter(),
			new SproutFields_PhoneSproutImportFieldImporter()
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
