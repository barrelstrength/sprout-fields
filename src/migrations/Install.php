<?php

namespace barrelstrength\sproutfields\migrations;

use craft\db\Migration;
use barrelstrength\sproutbase\app\fields\migrations\Install as SproutBaseFieldsInstall;

class Install extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $migration = new SproutBaseFieldsInstall();

        ob_start();
        $migration->safeUp();
        ob_end_clean();

        return true;
    }
}
