<?php
namespace Craft;

class SproutFields_PhoneFieldType extends BaseFieldType implements IPreviewableFieldType
{
	/**
	 * @return string
	 */
	public function getName()
	{
		return Craft::t('Phone Number');
	}

	/**
	 * @return array
	 */
	protected function defineSettings()
	{
		$default = sproutFields()->phone->getDefaultMask();

		return array(
			'customPatternErrorMessage' => array(AttributeType::String),
			'customPatternToggle'       => array(AttributeType::Bool),
			'inputMask'                 => array(AttributeType::Bool),
			'mask'                      => array(AttributeType::String, 'default' => $default),
			'placeholder'               => array(AttributeType::String),
		);
	}

	/**
	 * @return string
	 */
	public function getSettingsHtml()
	{
		return craft()->templates->render('sproutfields/_fieldtypes/phone/settings', array(
			'settings' => $this->getSettings()
		));
	}

	/**
	 * @param string $name
	 * @param mixed  $value
	 *
	 * @return string
	 */
	public function getInputHtml($name, $value)
	{
		$inputId          = craft()->templates->formatInputId($name);
		$namespaceInputId = craft()->templates->namespaceInputId($inputId);

		$settings = $this->getSettings();

		craft()->templates->includeJsResource('sproutfields/js/inputmask.js');
		craft()->templates->includeJsResource('sproutfields/js/jquery.inputmask.js');
		craft()->templates->includeJsResource('sproutfields/js/PhoneInputMask.js');
		craft()->templates->includeCssResource('sproutfields/css/sproutfields.css');

		return craft()->templates->render('sproutfields/_fieldtypes/phone/input', array(
			'id'          => $namespaceInputId,
			'name'        => $name,
			'value'       => $value,
			'settings'    => $settings,
			'placeholder' => $settings->placeholder
		));
	}

	/**
	 * Validates our fields submitted value beyond the checks
	 * that were assumed based on the content attribute.
	 *
	 * Returns 'true' or any custom validation errors.
	 *
	 * @param array $value
	 *
	 * @return true|string|array
	 */
	public function validate($value)
	{
		$settings = $this->getSettings();
		$handle = $this->model->handle;
		$name   = $this->model->name;
		$configs = $this->element->getContent()->getAttributeConfigs();

		$configAttribute = $configs[$handle];

		if ($settings['mask'] == "")
		{
			$settings['mask'] = sproutFields()->phone->getDefaultMask();
		}

		if (isset($configAttribute['required']) && $value == $settings['mask'])
		{
			return Craft::t($name . ' is required.');
		}

		if (!sproutFields()->phone->validate($value, $settings['mask']))
		{
			return sproutFields()->phone->getErrorMessage($this->model->name, $settings);
		}

		return true;
	}

	/**
	 * @param array $settings
	 *
	 * @return array
	 */
	public function prepSettings($settings)
	{
		// Clear input message when checkbox is uncheck
		if (empty($settings['customPatternToggle']))
		{
			// Set mask back to default when uncheck
			$default = sproutFields()->phone->getDefaultMask();

			$settings['mask'] = $default;

			$settings['customPatternErrorMessage'] = '';
		}

		return $settings;
	}

	/**
	 * @param mixed $value
	 *
	 * @return string
	 */
	public function getTableAttributeHtml($value)
	{
		$html = '<a href="tel:' . $value . '" target="_blank">' . $value . '</a>';

		return $html;
	}
}
