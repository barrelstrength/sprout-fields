<?php
/**
 * @link https://sprout.barrelstrengthdesign.com
 * @copyright Copyright (c) Barrel Strength Design LLC
 * @license https://craftcms.github.io/license
 */

namespace barrelstrength\sproutfields\integrations\sproutimport\importers\fields;

use barrelstrength\sproutbaseimport\base\FieldImporter;
use barrelstrength\sproutbaseimport\SproutBaseImport;
use barrelstrength\sproutforms\fields\formfields\EmailDropdown as EmailDropdownField;

class EmailDropdown extends FieldImporter
{
    /**
     * @return string
     */
    public function getModelName(): string
    {
        return EmailDropdownField::class;
    }

    /**
     * @return mixed
     */
    public function getMockData()
    {
        $settings = $this->model->settings;

        if (!empty($settings['options'])) {
            return SproutBaseImport::$app->fieldImporter->getRandomOptionValue($settings['options']);
        }

        return null;
    }
}
