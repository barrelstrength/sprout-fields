<?php

namespace barrelstrength\sproutfields\migrations;

use craft\db\Migration;
use barrelstrength\sproutfields\fields\Url;

/**
 * m180221_161526_link_fields migration.
 */
class m180221_161526_link_fields extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        // Link to Url
        $this->update('{{%fields}}', [
            'type' => Url::class
        ], [
            'type' => 'SproutFields_Link', 'context' => 'global'
        ], [], false);

        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m180221_161526_link_fields cannot be reverted.\n";
        return false;
    }
}
