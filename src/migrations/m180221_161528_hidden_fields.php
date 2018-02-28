<?php

namespace barrelstrength\sproutfields\migrations;

use craft\db\Migration;
use craft\fields\PlainText;
use craft\db\Query;

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
            ->select(['id', 'handle', 'instructions' , 'settings'])
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
            $settingsAsJson = json_encode($newSettings);
            $settings = json_decode($hiddenField['settings'], true);
            $instructions = $hiddenField['instructions'].' Hidden field pattern: '.$settings['value'] ?? '';
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
