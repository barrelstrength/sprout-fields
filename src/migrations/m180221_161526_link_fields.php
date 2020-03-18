<?php /** @noinspection ClassConstantCanBeUsedInspection */

namespace barrelstrength\sproutfields\migrations;

use craft\db\Migration;

class m180221_161526_link_fields extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp(): bool
    {
        // Link to Url
        $this->update('{{%fields}}', [
            'type' => 'barrelstrength\sproutfields\fields\Url'
        ], [
            'type' => 'SproutFields_Link', 'context' => 'global'
        ], [], false);

        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown(): bool
    {
        echo "m180221_161526_link_fields cannot be reverted.\n";

        return false;
    }
}
