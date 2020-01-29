<?php
/**
 * @link https://sprout.barrelstrengthdesign.com
 * @copyright Copyright (c) Barrel Strength Design LLC
 * @license https://craftcms.github.io/license
 */

namespace barrelstrength\sproutfields\migrations;

use barrelstrength\sproutfields\fields\RegularExpression;
use craft\db\Migration;

/**
 * m180221_161525_regular_expression_fields migration.
 */
class m180221_161525_regular_expression_fields extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp(): bool
    {
        // SproutFields_RegularExpression
        $this->update('{{%fields}}', [
            'type' => RegularExpression::class
        ], [
            'type' => 'SproutFields_RegularExpression', 'context' => 'global'
        ], [], false);

        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown(): bool
    {
        echo "m180221_161525_regular_expression_fields cannot be reverted.\n";

        return false;
    }
}
