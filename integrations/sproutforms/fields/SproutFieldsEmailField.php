<?php
namespace Craft;

/**
 * Class SproutFieldsEmailField
 *
 * @package Craft
 */
class SproutFieldsEmailField extends SproutFieldsBaseField
{
	/**
	 * @return string
	 */
	public function getType()
	{
		return 'SproutFields_Email';
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

		$attributes   = $field->getAttributes();
		$errorMessage = sproutFields()->email->getErrorMessage($attributes['name'], $settings);
		$placeholder  = (isset($settings['placeholder'])) ? $settings['placeholder'] : '';

		$rendered = craft()->templates->render(
			'email/input',
			array(
				'name'             => $field->handle,
				'value'            => $value,
				'field'            => $field,
				'pattern'          => $settings['customPattern'],
				'errorMessage'     => $errorMessage,
				'renderingOptions' => $renderingOptions,
				'placeholder'      => $placeholder
			)
		);

		$this->endRendering();

		return TemplateHelper::getRaw($rendered);
	}
}
