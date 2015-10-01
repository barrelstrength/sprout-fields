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

		craft()->templates->includeJsResource('sproutfields/js/jquery.js');
		craft()->templates->includeJsResource('sproutfields/js/inputmask.js');
		craft()->templates->includeJsResource('sproutfields/js/jquery.inputmask.js');
		craft()->templates->includeCssResource('sproutfields/css/phone.css');

		$rendered = craft()->templates->render(
			'phone/input',
			array(
				'name'             => $name,
				'value'            => $value,
				'settings'         => $settings,
				'field'            => $field,
				'mask'             => $settings['mask'],
				'namespaceInputId' => $namespaceInputId,
				'renderingOptions' => $renderingOptions
			)
		);

		$this->endRendering();

		return TemplateHelper::getRaw($rendered);
	}
}
