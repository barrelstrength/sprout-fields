<?php
namespace Craft;

class SproutFields_LinkFieldType extends BaseFieldType implements IPreviewableFieldType
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
			'placeholder'               => array(AttributeType::String),
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

		$settings = $this->getSettings();

		$fieldContext = sproutFields()->getFieldContext($this);

		return craft()->templates->render(
			'sproutfields/_fieldtypes/link/input',
			array(
				'id'           => $namespaceInputId,
				'name'         => $name,
				'value'        => $value,
				'fieldContext' => $fieldContext,
				'placeholder'  => $settings->placeholder
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
			return sproutFields()->link->getErrorMessage($this->model->name, $settings);
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
		// Clear input when checkbox is uncheck
		if (empty($settings['customPatternToggle']))
		{
			$settings['customPattern']             = '';
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
		$html = '<a href="' . $value . '" target="_blank">' . $value . '</a>';

		return $html;
	}
}
