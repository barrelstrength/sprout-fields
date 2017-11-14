<?php

namespace barrelstrength\sproutfields\migrations;

use craft\db\Migration;
use barrelstrength\sproutbase\migrations\sproutfields\Install as SproutBaseFieldsInstall;

class Install extends Migration
{
	// Public Methods
	// =========================================================================

	/**
	 * @inheritdoc
	 */
	public function safeUp()
	{
		$this->runSproutBaseInstall();

		return true;
	}

	// Protected Methods
	// =========================================================================

	protected function runSproutBaseInstall()
	{
		$migration = new SproutBaseFieldsInstall();

		ob_start();
		$migration->safeUp();
		ob_end_clean();
	}
}
