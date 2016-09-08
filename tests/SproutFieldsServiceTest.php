<?php

namespace Craft;

use \Mockery as m;

class SproutFieldsTest extends BaseTest
{
	public function setUp()
	{
		$this->loadDependencies();

		$this->fieldsService = new SproutFieldsService;
	}

	public function testIsSelected()
	{
		$options = array();

		$bools = array(false, false, false);

		foreach ($bools as $bool)
		{
			$object           = new \stdClass();
			$object->selected = $bool;

			$options[] = $object;
		}

		$result = $this->fieldsService->isAnyOptionsSelected($options);

		$this->assertFalse($result);

		$bools = array(false, true, false);

		foreach ($bools as $bool)
		{
			$object           = new \stdClass();
			$object->selected = $bool;

			$options[] = $object;
		}

		$result = $this->fieldsService->isAnyOptionsSelected($options);

		$this->assertTrue($result);
	}

	public function loadDependencies()
	{
		$dir = __DIR__;

		$map = array(
			'\\Craft\\SproutFieldsService' => '/../services/SproutFieldsService.php'
		);

		foreach ($map as $class => $path)
		{
			if (!class_exists($class))
			{
				require $dir . $path;
			}
		}
	}
}