<?php
/**
 * @link https://sprout.barrelstrengthdesign.com
 * @copyright Copyright (c) Barrel Strength Design LLC
 * @license https://craftcms.github.io/license
 */

namespace barrelstrength\sproutfields\integrations\sproutimport\importers\fields;

use barrelstrength\sproutbaseimport\base\FieldImporter;
use barrelstrength\sproutfields\fields\Email as EmailField;

class Email extends FieldImporter
{
    /**
     * @return string
     */
    public function getModelName(): string
    {
        return EmailField::class;
    }

    /**
     * @return mixed
     */
    public function getMockData()
    {
        $settings = $this->model->settings;

        // We cannot support regexes, as they may allow infinite characters such as (.*)
        if (!empty($settings['customPatternToggle']) && !empty($settings['customPattern'])) {
            return null;
        }

        return $this->fakerService->email;
    }
}
