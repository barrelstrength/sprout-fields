<?php
namespace Craft;

/**
 *
 */
class SproutFields_Link_SproutFormsFieldType extends BaseSproutFormsFieldType
{
	/**
	 * Returns the field's input HTML.
	 *
	 * @param string $name
	 * @param mixed  $value
	 * @return string
	 */
	public function getInputHtml($field, $value, $settings, $render = null)
	{
		return craft()->templates->render('fields/sproutlinkfield/input', array(
			'name'  => $field->handle,
			'value'=> $value,
		));
	}
}
