<?php
namespace Craft;

class SproutFields_NotesSproutImportFieldImporter extends BaseSproutImportFieldImporter
{
	/**
	 * @return string
	 */
	public function getModelName()
	{
		return 'SproutFields_Notes';
	}

	/**
	 * @return mixed
	 */
	public function getMockData()
	{
		// No fake data needed. Value is provided from field settings.
		return null;
	}
}
