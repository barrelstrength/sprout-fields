<?php /** @noinspection ClassConstantCanBeUsedInspection */

namespace barrelstrength\sproutfields\migrations;

use craft\db\Migration;
use craft\db\Query;
use craft\helpers\Json;

class m180221_161529_invisible_fields extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp(): bool
    {
        // Invisible to TextField
        $invisibleFields = (new Query())
            ->select(['id', 'handle', 'instructions', 'settings'])
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
            $settingsAsJson = Json::encode($newSettings);
            $settings = Json::decode($invisibleField['settings']);
            $instructions = $invisibleField['instructions'].' Invisible field pattern: '.$settings['value'] ?? '';
            $this->update('{{%fields}}', [
                'type' => 'craft\fields\PlainText',
                'settings' => $settingsAsJson,
                'instructions' => $instructions
            ], [
                'id' => $invisibleField['id']
            ], [], false);
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown(): bool
    {
        echo "m180221_161529_invisible_fields cannot be reverted.\n";

        return false;
    }
}
