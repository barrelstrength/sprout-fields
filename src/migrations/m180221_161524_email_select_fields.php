<?php
/**
 * @link https://sprout.barrelstrengthdesign.com
 * @copyright Copyright (c) Barrel Strength Design LLC
 * @license https://craftcms.github.io/license
 */

namespace barrelstrength\sproutfields\migrations;

use craft\db\Migration;
use craft\db\Query;
use craft\fields\Table;
use craft\helpers\Json;

/**
 * m180221_161524_email_select_fields migration.
 */
class m180221_161524_email_select_fields extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp(): bool
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
            $oldSettings = Json::decode($emailSelect['settings']);
            $band = 1;
            foreach ($oldSettings['options'] as $option) {
                $defaults['row'.$band] = ['col1' => $option['label'], 'col2' => $option['value']];
                $band++;
            }
            $newSettings['columns'] = $columns;
            $newSettings['defaults'] = $defaults;
            $newSettings['columnType'] = 'text';
            $settingsAsJson = Json::encode($newSettings);

            $this->update('{{%fields}}', ['type' => Table::class, 'settings' => $settingsAsJson], ['id' => $emailSelect['id']], [], false);
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown(): bool
    {
        echo "m180221_161524_email_select_fields cannot be reverted.\n";

        return false;
    }
}
