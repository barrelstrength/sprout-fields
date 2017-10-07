<?php

namespace barrelstrength\sproutfields\migrations;

use craft\db\Migration;
use barrelstrength\sproutcore\migrations\sproutfields\Install as SproutCoreFieldsInstall;

class Install extends Migration
{
	// Public Methods
	// =========================================================================

	/**
	 * @inheritdoc
	 */
	public function safeUp()
	{
		$this->runSproutCoreInstall();

		return true;
	}

	// Protected Methods
	// =========================================================================

	protected function runSproutCoreInstall()
	{
		$migration = new SproutCoreFieldsInstall();

		ob_start();
		$migration->safeUp();
		ob_end_clean();
	}
}
