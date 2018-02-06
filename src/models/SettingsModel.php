<?php

namespace barrelstrength\sproutfields\models;

use craft\base\Model;

/**
 * Class SettingsModel
 */
class SettingsModel extends Model
{
    /**
     * @var string
     */
    public $infoPrimaryDocumentation;

    /**
     * @var string
     */
    public $infoSecondaryDocumentation;

    /**
     * @var string
     */
    public $warningDocumentation;

    /**
     * @var string
     */
    public $dangerDocumentation;

    /**
     * @var string
     */
    public $highlightDocumentation;

}