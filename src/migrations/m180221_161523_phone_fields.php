<?php
/**
 * @link https://sprout.barrelstrengthdesign.com
 * @copyright Copyright (c) Barrel Strength Design LLC
 * @license https://craftcms.github.io/license
 */

namespace barrelstrength\sproutfields\migrations;

use craft\db\Migration;
use craft\db\Query;
use craft\fields\PlainText;
use craft\helpers\Json;

/**
 * m180221_161523_phone_fields migration.
 */
class m180221_161523_phone_fields extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp(): bool
    {
        // Phone - Update settings and Type
        $newSettings = [
            'placeholder' => '',
            'multiline' => '',
            'initialRows' => '4',
            'charLimit' => '255',
            'columnType' => 'string'
        ];

        $phoneFields = (new Query())
            ->select(['id', 'handle', 'settings'])
            ->from(['{{%fields}}'])
            ->where(['type' => 'SproutFields_Phone', 'context' => 'global'])
            ->all();

        foreach ($phoneFields as $phoneField) {
            $settingsAsJson = Json::encode($newSettings);
            $this->update('{{%fields}}', ['type' => PlainText::class, 'settings' => $settingsAsJson], ['id' => $phoneField['id']], [], false);
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown(): bool
    {
        echo "m180221_161523_phone_fields cannot be reverted.\n";

        return false;
    }
}
