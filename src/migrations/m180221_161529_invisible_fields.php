<?php

namespace barrelstrength\sproutfields\migrations;

use craft\db\Migration;
use craft\fields\PlainText;
use craft\db\Query;

/**
 * m180221_161529_invisible_fields migration.
 */
class m180221_161529_invisible_fields extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        // Invisible to TextField
        $invisibleFields = (new Query())
            ->select(['id', 'handle','instructions', 'settings'])
            ->from(['{{%fields}}'])
            ->where(['type' => 'SproutFields_Invisible', 'context' => 'global'])
            ->all();

        $newSettings = [
            'placeholder' => '',
            'multiline' => '',
            'initialRows' => '4',
            'charLimit' => '255',
            'columnType' => 'string'
        ];

        foreach ($invisibleFields as $invisibleField) {
            $settingsAsJson = json_encode($newSettings);
            $settings = json_decode($invisibleField['settings'], true);
            $instructions = $invisibleField['instructions'].' Invisible field pattern: '.$settings['value'] ?? '';
            $this->update('{{%fields}}', ['type' => PlainText::class, 'settings' => $settingsAsJson, 'instructions'=>$instructions], ['id' => $invisibleField['id']], [], false);
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m180221_161529_invisible_fields cannot be reverted.\n";
        return false;
    }
}
