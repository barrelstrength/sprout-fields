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

		$options  = $settings['options'];
		$options  = craft()->sproutFields_emailSelectField->obfuscateEmailAddresses($options);

		$rendered = craft()->templates->render(
			'emailselect/input',
			array(
				'name'    => $field->handle,
				'value'   => $value->getOptions(),
				'options' => $options,
				'field'   => $field
			)
		);

		$this->endRendering();

		return TemplateHelper::getRaw($rendered);
	}
}
