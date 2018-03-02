<?php

namespace barrelstrength\sproutfields\migrations;

use craft\db\Migration;
use barrelstrength\sproutfields\fields\RegularExpression;

/**
 * m180221_161525_regular_expression_fields migration.
 */
class m180221_161525_regular_expression_fields extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
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
    public function safeDown()
    {
        echo "m180221_161525_regular_expression_fields cannot be reverted.\n";
        return false;
    }
}
