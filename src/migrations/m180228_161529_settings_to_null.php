<?php

namespace barrelstrength\sproutfields\migrations;

use barrelstrength\sproutfields\SproutFields;
use craft\db\Migration;
use Craft;
use craft\db\Query;
use craft\helpers\FileHelper;
use craft\helpers\Json;
use craft\services\Plugins;

/**
 * m180228_161529_settings_to_null migration.
 */
class m180228_161529_settings_to_null extends Migration
{
    /**
     * @inheritdoc
     * @throws \Exception
     * @throws \yii\base\Exception
     */
    public function safeUp(): bool
    {
        $plugin = SproutFields::getInstance();

        $settingsModel = $plugin->getSettings();
        $settings = $settingsModel->getAttributes();
        $path = Craft::$app->getPath()->getConfigPath();

        foreach ($settings as $key => $css) {
            // Save code to file
            try {
                $file = $path.DIRECTORY_SEPARATOR.'sproutnotes'.DIRECTORY_SEPARATOR.$key.'.css';
                FileHelper::writeToFile($file, $css);
            } catch (\Throwable $e) {
                throw new Exception(Craft::t('sprout-fields', 'Something went wrong while creating custom style: '.$e->getMessage()));
            }
        }

        $projectConfig = Craft::$app->getProjectConfig();
        $projectConfig->set(Plugins::CONFIG_PLUGINS_KEY . '.' . $plugin->handle . '.settings', []);

        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown(): bool
    {
        echo "m180228_161529_settings_to_null cannot be reverted.\n";
        return false;
    }
}
