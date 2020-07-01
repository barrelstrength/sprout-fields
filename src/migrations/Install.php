<?php
/**
 * @link      https://sprout.barrelstrengthdesign.com
 * @copyright Copyright (c) Barrel Strength Design LLC
 * @license   https://craftcms.github.io/license
 */

namespace barrelstrength\sproutfields\migrations;

use barrelstrength\sproutbase\SproutBase;
use barrelstrength\sproutfields\SproutFields;
use craft\db\Migration;
use ReflectionException;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\base\NotSupportedException;
use yii\web\ServerErrorHttpException;

class Install extends Migration
{
    /**
     * @throws ReflectionException
     * @throws ErrorException
     * @throws Exception
     * @throws NotSupportedException
     * @throws ServerErrorHttpException
     */
    public function safeUp()
    {
        SproutBase::$app->config->runInstallMigrations(SproutFields::getInstance());
    }

    /**
     * @throws ReflectionException
     */
    public function safeDown()
    {
        SproutBase::$app->config->runUninstallMigrations(SproutFields::getInstance());
    }
}
