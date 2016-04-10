<?php
namespace Craft;

class SproutFields_EmailSproutImportFieldImporter extends BaseSproutImportFieldImporter
{
	/**
	 * @return mixed
	 */
	public function getMockData()
	{
		return $this->fakerService->email;
	}
}
