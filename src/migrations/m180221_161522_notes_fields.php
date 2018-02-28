<?php

namespace barrelstrength\sproutfields\migrations;

use craft\db\Migration;
use barrelstrength\sproutfields\fields\Notes;
use craft\db\Query;

/**
 * m180221_161522_notes_fields migration.
 */
class m180221_161522_notes_fields extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        // Notes - Update style to empty and Type
        $notesFields = (new Query())
            ->select(['id', 'handle', 'settings'])
            ->from(['{{%fields}}'])
            ->where(['type' => 'SproutFields_Notes', 'context' => 'global'])
            ->all();

        foreach ($notesFields as $noteField) {
            $settings = json_decode($noteField['settings'], true);
            $settings['style'] = '';
            $settings['notes'] = $settings['instructions'] ?? '';
            unset($settings['instructions']);
            $settingsAsJson = json_encode($settings);

            $this->update('{{%fields}}', ['type' => Notes::class, 'settings' => $settingsAsJson], ['id' => $noteField['id']], [], false);
        }
        // end notes
        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m180221_161522_notes_fields cannot be reverted.\n";
        return false;
    }
}
