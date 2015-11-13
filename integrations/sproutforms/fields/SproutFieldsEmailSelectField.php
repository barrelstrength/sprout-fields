<?php
namespace Craft;

class SproutFieldsEmailSelectField extends SproutFieldsBaseField
{

	/**
	 * @return string
	 */
	public function getType()
	{
		return 'SproutFields_EmailSelect';
	}

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

		$options = $field->settings['options'];

		// Set template to cpanel to get macro form
		$oldPath = craft()->path->getTemplatesPath();
		$newPath = craft()->path->getCpTemplatesPath();

		craft()->path->setTemplatesPath($newPath);
		
		$rendered = craft()->templates->render('_includes/forms/select', array(
			'name'  => $field->handle,
			'value'=> $value,
			'options' => $options,
		));

		craft()->path->setTemplatesPath($oldPath);
		$this->endRendering();

		return TemplateHelper::getRaw($rendered);
	}
}