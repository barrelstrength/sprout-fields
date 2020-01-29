<?php /**
 * @link https://sprout.barrelstrengthdesign.com
 * @copyright Copyright (c) Barrel Strength Design LLC
 * @license https://craftcms.github.io/license
 */ /** @noinspection ClassConstantCanBeUsedInspection */

namespace barrelstrength\sproutfields\migrations;

use barrelstrength\sproutbasefields\migrations\m190524_000000_add_dynamic_rendering_and_standalone_predefined_date_field;
use craft\db\Migration;

/**
 * m190524_000000_add_dynamic_rendering_and_standalone_predefined_date_field_sproutfields migration.
 */
class m190524_000000_add_dynamic_rendering_and_standalone_predefined_date_field_sproutfields extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp(): bool
    {
        $migration = new m190524_000000_add_dynamic_rendering_and_standalone_predefined_date_field();

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
        echo "m190524_000000_add_dynamic_rendering_and_standalone_predefined_date_field_sproutfields cannot be reverted.\n";

        return false;
    }
}
