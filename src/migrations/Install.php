<?php
/**
 * @link      https://sprout.barrelstrengthdesign.com
 * @copyright Copyright (c) Barrel Strength Design LLC
 * @license   https://craftcms.github.io/license
 */

namespace barrelstrength\sproutfields\migrations;

use barrelstrength\sproutbase\base\SproutDependencyInterface;
use barrelstrength\sproutbase\migrations\Install as SproutBaseInstall;
use barrelstrength\sproutbasefields\migrations\Install as SproutBaseFieldsInstall;
use barrelstrength\sproutfields\SproutFields;
use craft\db\Migration;

class Install extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp(): bool
    {
        $migration = new SproutBaseFieldsInstall();

        ob_start();
        $migration->safeUp();
        ob_end_clean();

        return true;
    }

    /**
     * @return bool
     */
    public function safeDown(): bool
    {
        /** @var SproutFields $plugin */
        $plugin = SproutFields::getInstance();

        $sproutBaseFieldsInUse = $plugin->dependencyInUse(SproutDependencyInterface::SPROUT_BASE_FIELDS);
        $sproutBaseInUse = $plugin->dependencyInUse(SproutDependencyInterface::SPROUT_BASE);

        if (!$sproutBaseFieldsInUse) {
            $migration = new SproutBaseFieldsInstall();

            ob_start();
            $migration->safeDown();
            ob_end_clean();
        }

        if (!$sproutBaseInUse) {
            $migration = new SproutBaseInstall();

            ob_start();
            $migration->safeDown();
            ob_end_clean();
        }

        return true;
    }
}
