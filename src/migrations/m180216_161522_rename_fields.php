<?php

namespace barrelstrength\sproutfields\migrations;

use craft\db\Migration;
use barrelstrength\sproutfields\fields\EmailDropdown;
use barrelstrength\sproutfields\fields\Notes;
use barrelstrength\sproutfields\fields\RegularExpression;
use barrelstrength\sproutfields\fields\Url;
use barrelstrength\sproutfields\fields\Phone;
use barrelstrength\sproutfields\fields\Email;
use craft\db\Query;

/**
 * m180216_161522_rename_fields migration.
 */
class m180216_161522_rename_fields extends Migration
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
            ->where(['type' => 'SproutFields_Notes'])
            ->all();

        foreach ($notesFields as $noteField) {
            $settings = json_decode($noteField['settings'], true);
            $settings['style'] = '';
            $settings['notes'] = $settings['instructions'] ?? '';
            unset($settings['instructions']);
            $settingsAsJson = json_encode($settings);

            $this->update('{{%fields}}', ['type' => Notes::class, 'settings' => $settingsAsJson], ['id' => $noteField['id']], [], false);
        }
        // We also renamed
        if (!$this->db->columnExists('{{%migrations}}', 'name')) {
            MigrationHelper::renameColumn('{{%migrations}}', 'version', 'name', $this);
        }
        // end notes

        // Phone - Update settings and Type
        $phoneFields = (new Query())
            ->select(['id', 'handle', 'settings'])
            ->from(['{{%fields}}'])
            ->where(['type' => 'SproutFields_Phone'])
            ->all();

        foreach ($phoneFields as $phoneField) {
            $newSettings = [];
            $settings = json_decode($phoneField['settings'], true);
            $newSettings['placeholder'] = $settings['placeholder'] ?? '';
            $newSettings['customPatternErrorMessage'] = $settings['customPatternErrorMessage'] ?? '';
            $newSettings['country'] = 'US';
            $newSettings['limitToSingleCountry'] = '';
            $settingsAsJson = json_encode($newSettings);

            $this->update('{{%fields}}', ['type' => Phone::class, 'settings' => $settingsAsJson], ['id' => $phoneField['id']], [], false);
        }
        // end Phone

        // Email Select to Email dropdown
        $this->update('{{%fields}}', [
            'type' => EmailDropdown::class
        ], [
            'type' => 'SproutFields_EmailSelect'
        ], [], false);

        // SproutFields_RegularExpression
        $this->update('{{%fields}}', [
            'type' => RegularExpression::class
        ], [
            'type' => 'SproutFields_RegularExpression'
        ], [], false);

        // Link to Url
        $this->update('{{%fields}}', [
            'type' => Url::class
        ], [
            'type' => 'SproutFields_Link'
        ], [], false);

        // Email
        $this->update('{{%fields}}', [
            'type' => Email::class
        ], [
            'type' => 'SproutFields_Email'
        ], [], false);

        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m180216_161522_rename_fields cannot be reverted.\n";
        return false;
    }
}
