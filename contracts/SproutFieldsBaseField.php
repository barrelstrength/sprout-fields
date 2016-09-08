<?php
namespace Craft;

/**
 * Class SproutFieldsBaseField
 *
 * @package Craft
 */
abstract class SproutFieldsBaseField extends SproutFormsBaseField
{
	/**
	 * @return string
	 */
	public function getTemplatesPath()
	{
		return craft()->path->getPluginsPath() . 'sproutfields/templates/_integrations/sproutforms/fields/';
	}
}
