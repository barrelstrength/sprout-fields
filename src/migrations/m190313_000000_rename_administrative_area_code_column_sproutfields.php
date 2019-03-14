<?php

namespace barrelstrength\sproutfields\migrations;

use craft\db\Migration;
use barrelstrength\sproutbasefields\migrations\m190313_000000_add_administrativeareacode_column;

/**
 * m190313_000000_rename_administrative_area_code_column_sproutfields migration.
 */
class m190313_000000_rename_administrative_area_code_column_sproutfields extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp(): bool
    {
        $migration = new m190313_000000_add_administrativeareacode_column();

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
        echo "m190313_000000_rename_administrative_area_code_column_sproutfields cannot be reverted.\n";
        return false;
    }
}
