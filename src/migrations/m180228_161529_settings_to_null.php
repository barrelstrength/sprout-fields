<?php

namespace barrelstrength\sproutfields\migrations;

use craft\db\Migration;
use Craft;
use craft\db\Query;
use craft\helpers\FileHelper;

/**
 * m180228_161529_settings_to_null migration.
 */
class m180228_161529_settings_to_null extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $plugin = (new Query())
            ->select(['id', 'settings'])
            ->from(['{{%plugins}}'])
            ->where(['handle' => 'sprout-fields'])
            ->one();

        $settings = json_decode($plugin['settings'], true);
        $path = Craft::$app->getPath()->getConfigPath();

        foreach ($settings as $key => $css) {
            // Save code to file
            try {
                $file = $path.DIRECTORY_SEPARATOR.'sproutnotes'.DIRECTORY_SEPARATOR.$key.'.css';
                FileHelper::writeToFile($file, $css);
            }catch (\Throwable $e) {
                throw new \Exception(Craft::t('sprout-fields','Something went wrong while creating custom style: '.$e->getMessage()));
            }
        }

        $this->update('{{%plugins}}', ['settings' => null], ['id' => $plugin['id']], [], false);

        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m180228_161529_settings_to_null cannot be reverted.\n";
        return false;
    }
}
