<?php

namespace Craft;

/**
 * Class SproutFieldsPhoneField
 *
 * @package Craft
 */
class SproutFieldsPhoneField extends SproutFieldsBaseField
{
	/**
	 * @var string
	 */
	protected $mask;

	/**
	 * @return string
	 */
	public function getType()
	{
		return 'SproutFields_Phone';
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

		$name             = $field->handle;
		$namespaceInputId = $this->getNamespace().'-'.$name;

		$pattern = craft()->sproutFields_phoneField->convertMaskToRegEx($settings['mask']);

		$pattern = trim($pattern, '/');

		$attributes = $field->getAttributes();
		$errorMessage = craft()->sproutFields_phoneField->getErrorMessage($attributes['name'], $settings);

		$rendered = craft()->templates->render(
			'phone/input',
			array(
				'name'             => $name,
				'value'            => $value,
				'settings'         => $settings,
				'field'            => $field,
				'mask'             => $settings['mask'],
				'pattern'          => $pattern,
				'errorMessage'     => $errorMessage,
				'namespaceInputId' => $namespaceInputId,
				'renderingOptions' => $renderingOptions
			)
		);

		$this->endRendering();

		return TemplateHelper::getRaw($rendered);
	}
}
