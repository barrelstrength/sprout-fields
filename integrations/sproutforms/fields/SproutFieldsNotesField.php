<?php

namespace Craft;

/**
 * Class SproutFieldsNotesField
 *
 * @package Craft
 */
class SproutFieldsNotesField extends SproutFieldsBaseField
{
	/**
	 * @return string
	 */
	public function getType()
	{
		return 'SproutFields_Notes';
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

		$name = $field->handle;
	
        $selectedStyle = $settings->styleOption;
		
		// Get our plugin settings
        $pluginSettings = craft()->plugins->getPlugin('sproutmoreinfo')->getSettings()->getAttributes();

        $selectedStyleCss = str_replace("{{ name }}", $name, $pluginSettings[$selectedStyle]);
		
		$rendered = craft()->templates->render('moreinfo/input', array(
			'settings' => $settings,
			'selectedStyleCss' => $selectedStyleCss
		));


		// $name             = $field->handle;
		// $namespaceInputId = $this->getNamespace().'-'.$name;

		// $pattern = craft()->sproutFields_phoneField->convertMaskToRegEx($settings['mask']);
		// $pattern = trim($pattern, '/');

		// $attributes = $field->getAttributes();
		// $errorMessage = craft()->sproutFields_phoneField->getErrorMessage($attributes['name'], $settings);

		// $rendered = craft()->templates->render(
		// 	'phone/input',
		// 	array(
		// 		'name'             => $name,
		// 		'value'            => $value,
		// 		'settings'         => $settings,
		// 		'field'            => $field,
		// 		'mask'             => $settings['mask'],
		// 		'pattern'          => $pattern,
		// 		'errorMessage'     => $errorMessage,
		// 		'namespaceInputId' => $namespaceInputId,
		// 		'renderingOptions' => $renderingOptions
		// 	)
		// );

		$this->endRendering();

		return TemplateHelper::getRaw($rendered);
	}
}
