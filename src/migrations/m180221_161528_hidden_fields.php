<?php /** @noinspection ClassConstantCanBeUsedInspection */

namespace barrelstrength\sproutfields\migrations;

use craft\db\Migration;
use craft\db\Query;
use craft\helpers\Json;

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

            $this->update('{{%fields}}', [
                'type' => 'craft\fields\PlainText',
                'settings' => $settingsAsJson,
                'instructions' => $instructions
            ], [
                'id' => $hiddenField['id']
            ], [], false);
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
