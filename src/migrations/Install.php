<?php

namespace barrelstrength\sproutfields\migrations;

use Craft;
use craft\config\DbConfig;
use craft\db\Migration;
use craft\models\Structure;
use barrelstrength\sproutseo\models\Settings;
use barrelstrength\sproutcore\migrations\sproutfields\AddressTable;

class Install extends Migration
{
	// Public Properties
	// =========================================================================

	/**
	 * @var string The database driver to use
	 */
	public $driver;

	// Public Methods
	// =========================================================================

	/**
	 * @inheritdoc
	 */
	public function safeUp()
	{
		$this->createAddressTable();

		return true;
	}

	/**
	 * @inheritdoc
	 */
	public function safeDown()
	{
		$sproutSeo = Craft::$app->plugins->getPlugin('sprout-seo');

		if (!$sproutSeo)
		{
			$migration = new AddressTable();

			ob_start();
			$migration->down();
			ob_end_clean();
		}
	}

	// Protected Methods
	// =========================================================================

	protected function createAddressTable()
	{
		$migration = new AddressTable();

		ob_start();
		$migration->up();
		ob_end_clean();
	}
}
