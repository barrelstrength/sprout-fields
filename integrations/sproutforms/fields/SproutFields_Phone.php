<?php

namespace Craft;

/**
 *
 */
class SproutFields_Phone extends SproutFieldsSproutFormsBaseField
{
	private $mask;
	/**
	 * Returns the field's input HTML.
	 *
	 * @param string $name
	 * @param mixed $value
	 * @return string
	 */
	public function getInputHtml($field, $value, $settings, array $renderingOptions = null)
	{
		$this->beginRendering();

		$name = $field->handle;

		$namespaceInputId = $this->getNamespace() . '-' . $name;

		craft()->templates->includeJsResource('sproutfields/js/jquery.js');
		craft()->templates->includeJsResource('sproutfields/js/inputmask.js');
		craft()->templates->includeJsResource('sproutfields/js/jquery.inputmask.js');

		craft()->templates->includeCssResource('sproutfields/css/phone.css');

		$rendered = craft()->templates->render('fields/sproutphonefield_phone/input', array(
			'name'     => $name,
			'value'    => $value,
			'settings' => $settings,
			'field'    => $field,
			'mask'     => $settings['mask'],
			'namespaceInputId' => $namespaceInputId,
			'renderingOptions' => $renderingOptions
		));


		$this->endRendering();

		return TemplateHelper::getRaw($rendered);
	}


	public function getType()
	{
		return 'SproutFields_Phone';
	}
}

?>