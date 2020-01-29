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
 * m180221_161528_hidden_fields migration.
 */
class m180221_161528_hidden_fields extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp(): bool
    {
        // Hidden to TextField
        $hiddenFields = (new Query())
            ->select(['id', 'handle', 'instructions', 'settings'])
            ->from(['{{%fields}}'])
            ->where(['type' => 'SproutFields_Hidden', 'context' => 'global'])
            ->all();

        $newSettings = [
            'placeholder' => '',
            'multiline' => '',
            'initialRows' => '4',
            'charLimit' => '255',
            'columnType' => 'string'
        ];

        foreach ($hiddenFields as $hiddenField) {
            $settingsAsJson = Json::encode($newSettings);
            $settings = Json::decode($hiddenField['settings']);
            $instructions = $hiddenField['instructions'].' Hidden field pattern: '.$settings['value'] ?? '';
            $this->update('{{%fields}}', ['type' => PlainText::class, 'settings' => $settingsAsJson, 'instructions' => $instructions], ['id' => $hiddenField['id']], [], false);
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown(): bool
    {
        echo "m180221_161528_hidden_fields cannot be reverted.\n";

        return false;
    }
}
