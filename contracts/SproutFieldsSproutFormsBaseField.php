<?php

namespace Craft;

abstract class SproutFieldsSproutFormsBaseField extends SproutFormsBaseField
{

	/**
	 * @return string
	 */
	public function getTemplatesPath()
	{
		return craft()->path->getPluginsPath().'sproutfields/integrations/sproutforms/templates';
	}

}