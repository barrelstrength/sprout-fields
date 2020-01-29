<?php
/**
 * @link https://sprout.barrelstrengthdesign.com
 * @copyright Copyright (c) Barrel Strength Design LLC
 * @license https://craftcms.github.io/license
 */

namespace barrelstrength\sproutfields\migrations;

use barrelstrength\sproutbasefields\migrations\Install as SproutBaseFieldsInstall;
use craft\db\Migration;

/**
 * m180328_073816_create_address_table migration.
 */
class m180328_073816_create_address_table extends Migration
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

    /**
     * @inheritdoc
     */
    public function safeDown(): bool
    {
        echo "m180328_073816_create_address_table cannot be reverted.\n";

        return false;
    }
}
