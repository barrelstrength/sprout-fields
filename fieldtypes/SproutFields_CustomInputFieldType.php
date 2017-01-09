<?php
namespace Craft;

class SproutFields_CustomInputFieldType extends BaseFieldType implements IPreviewableFieldType
{
	/**
	 * @return string
	 */
	public function getName()
	{
		return Craft::t('Custom Input');
	}

	/**
	 * @return array
	 */
	protected function defineSettings()
	{
		return array(
			'customPattern'               => array(AttributeType::String, 'required' => false),
			'customPatternErrorMessage'   => array(AttributeType::String),
			'customPatternSuccessMessage' => array(AttributeType::String),
			'inputType'                   => array(AttributeType::String, 'default' => 'text'),
			'placeholder'                 => array(AttributeType::String),
		);
	}

	/**
	 * @return string
	 */
	public function getSettingsHtml()
	{
		$settings = $this->getSettings();

		$inputTypes = $this->getInputTypes();

		return craft()->templates->render(
			'sproutfields/_fieldtypes/customInput/settings',
			array(
				'settings'   => $settings,
				'inputTypes' => $inputTypes
			)
		);
	}

	private function getInputTypes()
	{
		return array(
			array(
				'label' => 'Password',
				'value' => 'password'
			),
			array(
				'label' => 'Text',
				'value' => 'text'
			),
			array(
				'label' => 'Color',
				'value' => 'color'
			),
			array(
				'label' => 'Date',
				'value' => 'date'
			),
			array(
				'label' => 'Date Time',
				'value' => 'datetime'
			),
			array(
				'label' => 'Email',
				'value' => 'email'
			),
			array(
				'label' => 'Month',
				'value' => 'month'
			),
			array(
				'label' => 'Number',
				'value' => 'number'
			),
			array(
				'label' => 'Range',
				'value' => 'range'
			),
			array(
				'label' => 'Search',
				'value' => 'search'
			),
			array(
				'label' => 'Telephone',
				'value' => 'tel'
			),
			array(
				'label' => 'Time',
				'value' => 'time'
			),
			array(
				'label' => 'Url',
				'value' => 'url'
			),
			array(
				'label' => 'Week',
				'value' => 'week'
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
			'sproutfields/_fieldtypes/custominput/input',
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

		if (!sproutFields()->customInput->validate($value, $this->model))
		{
			return sproutFields()->customInput->getErrorMessage($this->model->name, $settings);
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
		$html = '<a href="' . $value . '" target="_blank">' . $value . '</a>';

		return $html;
	}
}
