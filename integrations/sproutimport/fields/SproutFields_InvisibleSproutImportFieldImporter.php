<?php
namespace Craft;

class SproutFields_InvisibleSproutImportFieldImporter extends BaseSproutImportFieldImporter
{
	/**
	 * @return string
	 */
	public function getModelName()
	{
		return 'SproutFields_Invisible';
	}

	/**
	 * @return mixed
	 */
	public function getMockData()
	{
		// Recommend use of custom imports for more accurate fake values
		return "INVISIBLE VALUE";
	}
}
