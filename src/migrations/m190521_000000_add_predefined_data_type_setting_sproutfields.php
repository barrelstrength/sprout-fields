<?php /** @noinspection ClassConstantCanBeUsedInspection */

namespace barrelstrength\sproutfields\migrations;

use barrelstrength\sproutbasefields\migrations\m190521_000000_add_predefined_data_type_setting;
use craft\db\Migration;

/**
 * m190521_000000_add_predefined_data_type_setting_sproutfields migration.
 */
class m190521_000000_add_predefined_data_type_setting_sproutfields extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp(): bool
    {
        $migration = new m190521_000000_add_predefined_data_type_setting();

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
        echo "m190521_000000_add_predefined_data_type_setting_sproutfields cannot be reverted.\n";
        return false;
    }
}
