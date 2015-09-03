<?php
namespace Craft;

class SproutEmailField_Email_SproutFormsFieldType extends BaseSproutFormsFieldType
{
	/**
	 * Returns the field's input HTML.
	 *
	 * @param string $name
	 * @param mixed  $value
	 * @return string
	 */
	public function getInputHtml($field, $value, $settings)
	{
		return craft()->templates->render('fields/sproutemailfield_email/input', array(
			'name'  => $field->handle,
			'value'=> $value,
		));
	}
}
