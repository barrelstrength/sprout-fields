<?php
namespace Craft;

/**
 * Class SproutFieldsInvisibleField
 *
 * @package Craft
 */
class SproutFieldsInvisibleField extends SproutFormsBaseField
{
	/**
	 * @return string
	 */
	public function getType()
	{
		return 'SproutFields_Invisible';
	}

	/**
	 * @return bool
	 */
	public function isPlainInput()
	{
		return true;
	}

	/**
	 * I'm invisible, I don't need to show up on the front end
	 * I do need to save my value to session to retrieve it via prepValueFromPost()
	 * You should also know that prepValueFromPost() won't be called unless you:
	 * - Set a hidden field to an empty value with my name
	 *
	 * @param FieldModel $field
	 * @param mixed      $value
	 * @param mixed      $settings
	 * @param array|null $renderingOptions
	 *
	 * @return \Twig_Markup
	 */
	public function getInputHtml($field, $value, $settings, array $renderingOptions = null)
	{
		try
		{
			$value = craft()->templates->renderObjectTemplate($settings['value'], parent::getFieldVariables());
		}
		catch (\Exception $e)
		{
			SproutFieldsPlugin::log($e->getMessage());
		}

		craft()->httpSession->add($field->handle, $value);

		// We really don't need the extra processing that it takes to render a template
		return TemplateHelper::getRaw(sprintf('<input type="hidden" name="%s" />', $field->handle));
	}
}
