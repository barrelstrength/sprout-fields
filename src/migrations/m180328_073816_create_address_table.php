<?php

namespace barrelstrength\sproutfields\migrations;

use craft\db\Migration;
use barrelstrength\sproutbase\app\fields\migrations\Install as SproutBaseFieldsInstall;
/**
 * m180328_073816_create_address_table migration.
 */
class m180328_073816_create_address_table extends Migration
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
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m180328_073816_create_address_table cannot be reverted.\n";
        return false;
    }
}
