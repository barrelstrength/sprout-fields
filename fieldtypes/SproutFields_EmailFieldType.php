<?php
namespace Craft;

class SproutFields_EmailFieldType extends BaseFieldType implements IPreviewableFieldType
{
	/**
	 * @return string
	 */
	public function getName()
	{
		return Craft::t('Email Address');
	}

	/**
	 * @return array
	 */
	protected function defineSettings()
	{
		return array(
			'customPattern'             => array(AttributeType::String),
			'customPatternToggle'       => array(AttributeType::Bool),
			'customPatternErrorMessage' => array(AttributeType::String),
			'uniqueEmail'               => array(AttributeType::Bool, 'default' => false),
			'placeholder'               => array(AttributeType::String),
		);
	}

	/**
	 * Display our settings
	 *
	 * @return string Returns the template which displays our settings
	 */
	public function getSettingsHtml()
	{
		$settings = $this->getSettings();

		return craft()->templates->render(
			'sproutfields/_fieldtypes/email/settings',
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

		// Set this to false for Quick Entry Dashboard Widget
		$elementId = ($this->element != null) ? $this->element->id : false;

		return craft()->templates->render(
			'sproutfields/_fieldtypes/email/input',
			array(
				'id'           => $namespaceInputId,
				'name'         => $name,
				'value'        => $value,
				'elementId'    => $elementId,
				'fieldContext' => $fieldContext,
				'placeholder'  => $settings->placeholder

			)
		);
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
		$customPattern = $this->model->settings['customPattern'];
		$checkPattern  = $this->model->settings['customPatternToggle'];

		if (!sproutFields()->email->validateEmailAddress($value, $customPattern, $checkPattern))
		{
			return sproutFields()->email->getErrorMessage($this->model->name, $this->model->settings);
		}

		$uniqueEmail = $this->model->settings['uniqueEmail'];

		if ($uniqueEmail && !sproutFields()->email->validateUniqueEmailAddress($value, $this->element, $this->model))
		{
			return Craft::t($this->model->name . ' must be a unique email.');
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
		$html = '<a href="mailto:' . $value . '" target="_blank">' . $value . '</a>';

		return $html;
	}
}
