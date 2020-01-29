<?php
/**
 * @link https://sprout.barrelstrengthdesign.com
 * @copyright Copyright (c) Barrel Strength Design LLC
 * @license https://craftcms.github.io/license
 */

namespace barrelstrength\sproutfields\migrations;

use barrelstrength\sproutfields\fields\Notes;
use craft\db\Migration;
use craft\db\Query;
use craft\helpers\Json;

/**
 * m180221_161522_notes_fields migration.
 */
class m180221_161522_notes_fields extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp(): bool
    {
        // Notes - Update style to empty and Type
        $notesFields = (new Query())
            ->select(['id', 'handle', 'settings'])
            ->from(['{{%fields}}'])
            ->where(['type' => 'SproutFields_Notes', 'context' => 'global'])
            ->all();

        foreach ($notesFields as $noteField) {
            $settings = Json::decode($noteField['settings']);
            $settings['style'] = '';
            $settings['notes'] = $settings['instructions'] ?? '';
            unset($settings['instructions']);
            $settingsAsJson = Json::encode($settings);

            $this->update('{{%fields}}', ['type' => Notes::class, 'settings' => $settingsAsJson], ['id' => $noteField['id']], [], false);
        }

        // end notes
        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown(): bool
    {
        echo "m180221_161522_notes_fields cannot be reverted.\n";

        return false;
    }
}
