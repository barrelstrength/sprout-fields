<?php
/**
 * @link      https://sprout.barrelstrengthdesign.com
 * @copyright Copyright (c) Barrel Strength Design LLC
 * @license   https://craftcms.github.io/license
 */

namespace barrelstrength\sproutfields\migrations;

use barrelstrength\sproutbase\config\base\DependencyInterface;
use barrelstrength\sproutbase\migrations\Install as SproutBaseInstall;
use barrelstrength\sproutbase\app\fields\migrations\Install as SproutBaseFieldsInstall;
use barrelstrength\sproutbase\SproutBase;
use barrelstrength\sproutfields\SproutFields;
use craft\db\Migration;

class Install extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp(): bool
    {
        SproutBase::$app->config->runInstallMigrations(SproutFields::getInstance());

        return true;
    }

    /**
     * @return bool
     */
    public function safeDown(): bool
    {
        SproutBase::$app->config->runUninstallMigrations(SproutFields::getInstance());

        return true;
    }
}
