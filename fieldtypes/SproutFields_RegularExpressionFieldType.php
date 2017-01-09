<?php
namespace Craft;

class SproutFields_RegularExpressionFieldType extends BaseFieldType implements IPreviewableFieldType
{
	/**
	 * @return string
	 */
	public function getName()
	{
		return Craft::t('Regular Expression');
	}

	/**
	 * @return array
	 */
	protected function defineSettings()
	{
		return array(
			'customPattern'             => array(AttributeType::String, 'required' => false),
			'customPatternErrorMessage' => array(AttributeType::String),
			'placeholder'               => array(AttributeType::String),
		);
	}

	/**
	 * @return string
	 */
	public function getSettingsHtml()
	{
		$settings = $this->getSettings();

		return craft()->templates->render('sproutfields/_fieldtypes/regularexpression/settings', array(
			'settings' => $settings
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

		$fieldContext = sproutFields()->getFieldContext($this);

		return craft()->templates->render(
			'sproutfields/_fieldtypes/regularexpression/input',
			array(
				'id'           => $namespaceInputId,
				'settings'     => $settings,
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

		if (!sproutFields()->regularExpression->validate($value, $this->model))
		{
			return sproutFields()->regularExpression->getErrorMessage($this->model->name, $settings);
		}

		return true;
	}

	/**
	 * @param mixed $value
	 *
	 * @return string
	 */
	public function getTableAttributeHtml($value)
	{
		return $value;
	}
}
