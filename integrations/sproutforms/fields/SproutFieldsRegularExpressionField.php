<?php
namespace Craft;

/**
 * Class SproutFieldsRegularExpressionField
 *
 * @package Craft
 */
class SproutFieldsRegularExpressionField extends SproutFieldsBaseField
{
	/**
	 * @return string
	 */
	public function getType()
	{
		return 'SproutFields_RegularExpression';
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

		$placeholder  = (isset($settings['placeholder'])) ? $settings['placeholder'] : '';

		$pattern = preg_quote($settings['customPattern']);

		// Here we undo the preg_quote treatment of the dashes. It
		// feels hacky but seems to be necessary to get the HTML5
		// pattern="" attribute to validate on the front-end without
		// throwing errors as the user types
		$pattern = preg_replace('/\\\\-/', '-', $pattern);

		$rendered = craft()->templates->render(
			'regularexpression/input',
			array(
				'name'             => $field->handle,
				'value'            => $value,
				'field'            => $field,
				'pattern'          => $pattern,
				'errorMessage'     => $settings['customPatternErrorMessage'],
				'renderingOptions' => $renderingOptions,
				'placeholder'      => $placeholder
			)
		);

		$this->endRendering();

		return TemplateHelper::getRaw($rendered);
	}
}
