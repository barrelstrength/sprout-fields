<?php /** @noinspection ClassConstantCanBeUsedInspection */

namespace barrelstrength\sproutfields\migrations;

use craft\db\Migration;

class m180221_161525_regular_expression_fields extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp(): bool
    {
        // This migration will no longer get triggered. the update_type migration will handle this.
        
        // SproutFields_RegularExpression
        $this->update('{{%fields}}', [
            'type' => 'barrelstrength\sproutfields\fields\RegularExpression'
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
