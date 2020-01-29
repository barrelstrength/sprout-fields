<?php
/**
 * @link https://sprout.barrelstrengthdesign.com
 * @copyright Copyright (c) Barrel Strength Design LLC
 * @license https://craftcms.github.io/license
 */

namespace barrelstrength\sproutfields\migrations;

use Craft;
use craft\db\Migration;
use craft\helpers\FileHelper;
use craft\services\Plugins;
use Throwable;
use yii\base\Exception;

/**
 * m180228_161529_settings_to_null migration.
 */
class m180228_161529_settings_to_null extends Migration
{
    /**
     * @inheritdoc
     * @throws \Exception
     * @throws Exception
     */
    public function safeUp(): bool
    {
        $pluginHandle = 'sprout-fields';
        $projectConfig = Craft::$app->getProjectConfig();
        $settings = $projectConfig->get(Plugins::CONFIG_PLUGINS_KEY.'.'.$pluginHandle.'.settings');
        $path = Craft::$app->getPath()->getConfigPath();

        if (is_array($settings)) {
            foreach ($settings as $key => $css) {
                // Save code to file
                try {
                    $file = $path.DIRECTORY_SEPARATOR.'sproutnotes'.DIRECTORY_SEPARATOR.$key.'.css';
                    FileHelper::writeToFile($file, $css);
                } catch (Throwable $e) {
                    Craft::error('Something went wrong while creating a custom style config file for the Notes field: '.$e->getMessage(), __METHOD__);
                }
            }
        }

        $projectConfig->set(Plugins::CONFIG_PLUGINS_KEY.'.'.$pluginHandle.'.settings', null);

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
