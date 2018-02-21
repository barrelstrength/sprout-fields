<?php

namespace barrelstrength\sproutfields\migrations;

use craft\db\Migration;
use craft\fields\PlainText;

/**
 * m180221_161528_hidden_fields migration.
 */
class m180221_161528_hidden_fields extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        // Hidden to TextField
        $hiddenFields = (new Query())
            ->select(['id', 'handle', 'settings'])
            ->from(['{{%fields}}'])
            ->where(['type' => 'SproutFields_Hidden'])
            ->all();

        $newSettings = [
            'placeholder' => '',
            'multiline' => '',
            'initialRows' => '4',
            'charLimit' => '255',
            'columnType' => 'string'
        ];

        foreach ($hiddenFields as $hiddenField) {
            $settingsAsJson = json_encode($newSettings);
            $settings = json_decode($hiddenField['settings'], true);
            $instructions = $settings['value'] ?? '';
            $this->update('{{%fields}}', ['type' => PlainText::class, 'settings' => $settingsAsJson, 'instructions'=>$instructions], ['id' => $hiddenField['id']], [], false);
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m180221_161528_hidden_fields cannot be reverted.\n";
        return false;
    }
}
