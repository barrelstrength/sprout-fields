<?php
namespace Craft;

class SproutFields_EmailSelectSproutImportFieldImporter extends BaseSproutImportFieldImporter
{
	/**
	 * @return string
	 */
	public function getModelName()
	{
		return 'SproutFields_EmailSelect';
	}

	/**
	 * @return mixed
	 */
	public function getMockData()
	{
		$settings = $this->model->settings;

		if (!empty($settings['options']))
		{
			return sproutImport()->mockData->getRandomOptionValue($settings['options']);
		}

		return null;
	}
}
