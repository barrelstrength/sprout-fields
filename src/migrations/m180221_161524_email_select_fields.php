<?php

namespace barrelstrength\sproutfields\migrations;

use craft\db\Migration;
use craft\fields\Table;
use craft\db\Query;

/**
 * m180221_161524_email_select_fields migration.
 */
class m180221_161524_email_select_fields extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        // Email Select to Table
        $columns['col1'] = [
            'heading' => 'Label',
            'handle' => 'label',
            'width' => '',
            'type' => 'singleline'
        ];
        $columns['col2'] = [
            'heading' => 'Value',
            'handle' => 'value',
            'width' => '',
            'type' => 'singleline'
        ];

        $emailSelects = (new Query())
            ->select(['id', 'handle', 'settings'])
            ->from(['{{%fields}}'])
            ->where(['type' => 'SproutFields_EmailSelect', 'context' => 'global'])
            ->all();
        $defaults = [];
        foreach ($emailSelects as $emailSelect) {
            $newSettings = [];
            $oldSettings = json_decode($emailSelect['settings'], true);
            $band = 1;
            foreach ($oldSettings['options'] as $option) {
                $defaults['row'.$band] = ['col1' => $option['label'], 'col2'=> $option['value']];
                $band++;
            }
            $newSettings['columns'] = $columns;
            $newSettings['defaults'] = $defaults;
            $newSettings['columnType'] = 'text';
            $settingsAsJson = json_encode($newSettings);

            $this->update('{{%fields}}', ['type' => Table::class, 'settings' => $settingsAsJson], ['id' => $emailSelect['id']], [], false);
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m180221_161524_email_select_fields cannot be reverted.\n";
        return false;
    }
}
