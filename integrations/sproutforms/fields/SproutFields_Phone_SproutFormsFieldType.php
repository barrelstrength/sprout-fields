<?php

namespace Craft;

/**
 *
 */
class SproutFields_Phone_SproutFormsFieldType extends BaseSproutFormsFieldType
{
	private $mask;
	/**
	 * Returns the field's input HTML.
	 *
	 * @param string $name
	 * @param mixed $value
	 * @return string
	 */
	public function getInputHtml($field, $value, $settings, $renderingOptions = null)
	{

		$name = $field->handle;

		$namespaceInputId = $this->getNamespace() . '-' . $name;

		craft()->templates->includeJsResource('sproutphonefield/js/jquery.js');
		craft()->templates->includeJsResource('sproutphonefield/js/inputmask.js');
		craft()->templates->includeJsResource('sproutphonefield/js/jquery.inputmask.js');

		craft()->templates->includeCssResource('sproutphonefield/css/phone.css');

		return craft()->templates->render('fields/sproutphonefield_phone/input', array(
			'name' => $name,
			'value' => $value,
			'settings' => $settings,
			'mask' => $settings['mask'],
			'namespaceInputId' => $namespaceInputId
		));
	}
}

?>