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

		$name             = $field->handle;
		$namespaceInputId = $this->getNamespace() . '-' . $name;

		$selectedStyle    = $settings['style'];
		$pluginSettings   = craft()->plugins->getPlugin('sproutfields')->getSettings()->getAttributes();

		$selectedStyleCss = "";
		if (isset($pluginSettings[$selectedStyle]))
		{
			$selectedStyleCss = str_replace("{{ name }}", $name, $pluginSettings[$selectedStyle]);
		}
		$rendered = craft()->templates->render('notes/input', array(
			'id'               => $namespaceInputId,
			'settings'         => $settings,
			'selectedStyleCss' => $selectedStyleCss
		));

		$this->endRendering();

		return TemplateHelper::getRaw($rendered);
	}
}
