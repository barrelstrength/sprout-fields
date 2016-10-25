<?php
namespace Craft;

class SproutFieldsEmailSelectField extends SproutFieldsBaseField
{
	/**
	 * @return string
	 */
	public function getType()
	{
		return 'SproutFields_EmailSelect';
	}

	/**
	 * @param FieldModel $field
	 * @param mixed      $value
	 * @param mixed      $settings
	 * @param array|null $renderingOptions
	 *
	 * @return \Twig_Markup
	 */
	public function getInputHtml($field, $value, $settings, array $renderingOptions = null)
	{
		$this->beginRendering();

		$selectedValue = isset($value->value) ? $value->value : null;

		$options = $settings['options'];
		$options = sproutFields()->emailSelect->obfuscateEmailAddresses($options, $selectedValue);

		$rendered = craft()->templates->render(
			'emailselect/input',
			array(
				'name'     => $field->handle,
				'value'    => $value,
				'options'  => $options,
				'settings' => $settings,
				'field'    => $field
			)
		);

		$this->endRendering();

		return TemplateHelper::getRaw($rendered);
	}
}
