<?php

namespace barrelstrength\sproutfields\migrations;

use craft\db\Migration;
use barrelstrength\sproutfields\fields\Email;

/**
 * m180221_161527_email_fields migration.
 */
class m180221_161527_email_fields extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
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
    public function safeDown()
    {
        echo "m180221_161527_email_fields cannot be reverted.\n";
        return false;
    }
}
