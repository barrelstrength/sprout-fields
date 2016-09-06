<?php
namespace Craft;

class SproutFields_HiddenSproutImportFieldImporter extends BaseSproutImportFieldImporter
{
	/**
	 * @return string
	 */
	public function getModelName()
	{
		return 'SproutFields_Hidden';
	}

	/**
	 * @return mixed
	 */
	public function getMockData()
	{
		// Recommend use of custom imports for more accurate fake values
		return "HIDDEN VALUE";
	}
}
