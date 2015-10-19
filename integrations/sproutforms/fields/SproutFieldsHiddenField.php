<?php

namespace Craft;

/**
 * Class SproutFieldsHiddenField
 *
 * @package Craft
 */
class SproutFieldsHiddenField extends SproutFieldsBaseField
{
	/**
	 * @return string
	 */
	public function getType()
	{
		return 'SproutFields_Hidden';
	}

	public function isPlainInput()
	{
		return true;
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

		try
		{
			$value = craft()->templates->renderObjectTemplate($settings['value'], parent::getFieldVariables());
		}
		catch (\Exception $e)
		{
			SproutFieldsPlugin::log($e->getMessage(), LogLevel::Error);
		}

		$rendered = craft()->templates->render(
			'hidden/input',
			array(
				'name'             => $field->handle,
				'value'            => $value,
				'field'            => $field,
				'renderingOptions' => $renderingOptions
			)
		);

		$this->endRendering();

		return TemplateHelper::getRaw($rendered);
	}
}
