<?php
namespace Craft;

class SproutFields_LinkSproutImportFieldImporter extends BaseSproutImportFieldImporter
{
	/**
	 * @return string
	 */
	public function getModelName()
	{
		return 'SproutFields_Link';
	}

	/**
	 * @return mixed
	 */
	public function getMockData()
	{
		$settings = $this->model->settings;

		// We cannot support regexes, as they may allow infinite characters such as (.*)
		if (!empty($settings['customPatternToggle']) && !empty($settings['customPattern']))
		{
			return null;
		}

		return $this->fakerService->url;
	}
}
