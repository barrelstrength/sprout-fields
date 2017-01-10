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

		$pattern = $settings['customPattern'];

		// Do no escape "-" html5 does not treat it as special chars
		$pattern = str_replace("\\-", '-', $pattern);

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
