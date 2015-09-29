<?php
namespace Craft;

/**
 *
 */
class SproutFields_Link extends SproutFieldsSproutFormsBaseField
{
	/**
	 * Returns the field's input HTML.
	 *
	 * @param string $name
	 * @param mixed  $value
	 * @return string
	 */
	public function getInputHtml($field, $value, $settings, array $renderingOptions = null)
	{

		$this->beginRendering();

		$rendered = craft()->templates->render('fields/sproutlinkfield/input', array(
			'name'  => $field->handle,
			'value'=> $value,
			'renderingOptions' => $renderingOptions
		));

		$this->endRendering();

		return TemplateHelper::getRaw($rendered);
	}

	public function getType()
	{
		return 'SproutFields_Link';
	}

}
