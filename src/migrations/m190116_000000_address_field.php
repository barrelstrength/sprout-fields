<?php
/**
 * @link https://sprout.barrelstrengthdesign.com
 * @copyright Copyright (c) Barrel Strength Design LLC
 * @license https://craftcms.github.io/license
 */

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
    public function safeUp(): bool
    {
        $fields = (new Query())
            ->select(['id', 'handle', 'settings'])
            ->from(['{{%fields}}'])
            ->where(['type' => Address::class])
            ->all();

        foreach ($fields as $field) {
            $settings = Json::decode($field['settings']);
            $settings['showCountryDropdown'] = $settings['hideCountryDropdown'] ?? '';
            if (isset($settings['hideCountryDropdown'])) {
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
    public function safeDown(): bool
    {
        echo "m190116_000000_address_field cannot be reverted.\n";

        return false;
    }
}
