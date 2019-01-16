<?php

namespace barrelstrength\sproutfields\migrations;

use barrelstrength\sproutfields\fields\Address;
use craft\db\Migration;
use craft\db\Query;
use craft\helpers\Json;

/**
 * m190116_000000_address_field migration.
 */
class m190116_000000_address_field extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $fields = (new Query())
            ->select(['id', 'handle', 'settings'])
            ->from(['{{%fields}}'])
            ->where(['type' => Address::class])
            ->all();

        foreach ($fields as $field) {
            $settings = json_decode($field['settings'], true);
            $settings['showCountryDropdown'] = $settings['hideCountryDropdown'] ?? '';
            if (isset($settings['hideCountryDropdown'])){
                unset($settings['hideCountryDropdown']);
            }
            $settingsAsJson = Json::encode($settings);
            $this->update('{{%fields}}', ['settings' => $settingsAsJson], ['id' => $field['id']], [], false);
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m190116_000000_address_field cannot be reverted.\n";
        return false;
    }
}
