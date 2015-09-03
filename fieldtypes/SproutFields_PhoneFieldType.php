<?php
namespace Craft;

class SproutFields_PhoneFieldType extends BaseFieldType
{
	protected $default = "###-###-####";

	public function getName()
	{
		return Craft::t('Phone Number');
	}

	protected function defineSettings()
	{
		// @todo - the default values set here don't seem to be respected when a field type is saved
		// @todo - can probably combine behavior of 'mask' and 'default' throughout using models
		// and logic instead of additional settings
		return array(
			'inputMask' => AttributeType::Bool,
			'mask'      => array(AttributeType::String, 'default' => $this->default),
			'default'   => array(AttributeType::String, 'default' => $this->default),
		);
	}

	public function getSettingsHtml()
	{
		return craft()->templates->render('sproutfields/_fields/phonefield/settings', array(
			'settings' => $this->getSettings()
		));
	}

	/**
	 * Define database column
	 *
	 * @return AttributeType::String
	 */
	public function defineContentAttribute()
	{
		return array(AttributeType::String);
	}

	/**
	 * Display our fieldtype
	 *
	 * @param string $name Our fieldtype handle
	 * @return string Return our fields input template
	 */
	public function getInputHtml($name, $value)
	{
		$inputId = craft()->templates->formatInputId($name);
		$namespaceInputId = craft()->templates->namespaceInputId($inputId);

		$settings = $this->getSettings();
		$settings['default'] = $this->default;

		craft()->templates->includeJsResource('sproutfields/js/inputmask.js');
		craft()->templates->includeJsResource('sproutfields/js/jquery.inputmask.js');
		craft()->templates->includeJsResource('sproutfields/js/PhoneInputMask.js');
		craft()->templates->includeCssResource('sproutfields/css/phone.css');

		return craft()->templates->render('sproutfields/_fields/phonefield/input', array(
			'id' => $namespaceInputId,
			'name' => $name,
			'value' => $value,
			'settings' => $settings
		));
	}

	/**
	 * Validates our fields submitted value beyond the checks
	 * that were assumed based on the content attribute.
	 *
	 * Returns 'true' or any custom validation errors.
	 *
	 * @param array $value
	 * @return true|string|array
	 */
	public function validate($value)
	{
		$settings = $this->getSettings();

		if ($settings['mask'] == "")
		{
			$settings['mask'] = $this->default;
		}

		if (!craft()->sproutFields_PhoneField->validate($value, $settings))
		{
			return Craft::t($this->model->name . ' is invalid. Required format: ' . $settings['mask']);
		}

		return true;
	}
}
