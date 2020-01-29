<?php
/**
 * @link https://sprout.barrelstrengthdesign.com
 * @copyright Copyright (c) Barrel Strength Design LLC
 * @license https://craftcms.github.io/license
 */

namespace barrelstrength\sproutfields\migrations;

use barrelstrength\sproutfields\fields\Url;
use craft\db\Migration;

/**
 * m180221_161526_link_fields migration.
 */
class m180221_161526_link_fields extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp(): bool
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
    public function safeDown(): bool
    {
        echo "m180221_161526_link_fields cannot be reverted.\n";

        return false;
    }
}
