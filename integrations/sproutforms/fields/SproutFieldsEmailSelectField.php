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
	 * Returns the field's input HTML.
	 *
	 * @param string $name
	 * @param mixed  $value
	 * @return string
	 */
	public function getInputHtml($field, $value, $settings, array $renderingOptions = null)
	{
		$this->beginRendering();

		$options = $field->settings['options'];

		$options = craft()->sproutFields_emailSelectField->obfuscateEmailAddresses($options);

		$rendered = craft()->templates->render('emailselect/input', array(
			'name'  => $field->handle,
			'value'=> $value,
			'options' => $options,
		));

		$this->endRendering();

		return TemplateHelper::getRaw($rendered);
	}
}