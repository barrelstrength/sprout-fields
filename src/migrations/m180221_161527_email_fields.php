<?php
/**
 * @link https://sprout.barrelstrengthdesign.com
 * @copyright Copyright (c) Barrel Strength Design LLC
 * @license https://craftcms.github.io/license
 */

namespace barrelstrength\sproutfields\migrations;

use barrelstrength\sproutfields\fields\Email;
use craft\db\Migration;

/**
 * m180221_161527_email_fields migration.
 */
class m180221_161527_email_fields extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp(): bool
    {
        // Email
        $this->update('{{%fields}}', [
            'type' => Email::class
        ], [
            'type' => 'SproutFields_Email', 'context' => 'global'
        ], [], false);

        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown(): bool
    {
        echo "m180221_161527_email_fields cannot be reverted.\n";

        return false;
    }
}
