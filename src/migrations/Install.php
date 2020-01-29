<?php

namespace barrelstrength\sproutfields\migrations;

use barrelstrength\sproutbasefields\migrations\Install as SproutBaseFieldsInstall;
use craft\db\Migration;

class Install extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp(): bool
    {
        $migration = new SproutBaseFieldsInstall();

        ob_start();
        $migration->safeUp();
        ob_end_clean();

        return true;
    }
}
