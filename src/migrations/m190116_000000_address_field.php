<?php /** @noinspection ClassConstantCanBeUsedInspection */

namespace barrelstrength\sproutfields\migrations;

use craft\db\Migration;
use craft\db\Query;
use craft\helpers\Json;

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
            ->where(['type' => 'barrelstrength\sproutfields\fields\Address'])
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
