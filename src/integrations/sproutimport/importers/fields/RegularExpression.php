<?php
/**
 * @link https://sprout.barrelstrengthdesign.com
 * @copyright Copyright (c) Barrel Strength Design LLC
 * @license https://craftcms.github.io/license
 */

namespace barrelstrength\sproutfields\integrations\sproutimport\importers\fields;

use barrelstrength\sproutbaseimport\base\FieldImporter;
use barrelstrength\sproutfields\fields\RegularExpression as RegularExpressionField;

class RegularExpression extends FieldImporter
{
    /**
     * @return string
     */
    public function getModelName(): string
    {
        return RegularExpressionField::class;
    }

    /**
     * @return mixed
     */
    public function getMockData()
    {
        $settings = $this->model->settings;

        if ($settings['customPattern'] === null) {
            return null;
        }

        return $this->fakerService->regexify($settings['customPattern']);
    }
}
