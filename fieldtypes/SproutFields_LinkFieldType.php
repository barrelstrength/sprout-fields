<?php
namespace Craft;

class SproutFields_LinkFieldType extends BaseFieldType
{
	/**
	 * @return string
	 */
	public function getName()
	{
		return Craft::t('Link');
	}

	/**
	 * @return array
	 */
	protected function defineSettings()
	{
		return array(
			'customPattern'             => array(AttributeType::String),
			'customPatternErrorMessage' => array(AttributeType::String),
			'customPatternToggle'       => array(AttributeType::Bool),
		);
	}

	/**
	 * @return string
	 */
	public function getSettingsHtml()
	{
		$settings = $this->getSettings();

		return craft()->templates->render(
			'sproutfields/_fieldtypes/link/settings',
			array(
				'settings' => $settings
			)
		);
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

		return craft()->templates->render(
			'sproutfields/_fieldtypes/link/input',
			array(
				'id'           => $namespaceInputId,
				'name'         => $name,
				'value'        => $value,
				'fieldContext' => $this->element->getFieldContext()
			)
		);
	}

	/**
	 * Validates submitted value beyond the checks
	 * that were assumed based on the content attribute.
	 *
	 * @param array $value
	 *
	 * @return true|string|array
	 */
	public function validate($value)
	{
		$settings = $this->model->settings;

		if (!sproutFields()->link->validate($value, $this->model))
		{
			if ($settings['customPattern'] && $settings['customPatternErrorMessage'])
			{
				return Craft::t($settings['customPatternErrorMessage']);
			}

			return Craft::t($this->model->name.' must be a valid link.');
		}

		return true;
	}
}
