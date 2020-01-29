<?php
/**
 * @link https://sprout.barrelstrengthdesign.com
 * @copyright Copyright (c) Barrel Strength Design LLC
 * @license https://craftcms.github.io/license
 */

namespace barrelstrength\sproutfields\integrations\sproutimport\importers\fields;

use barrelstrength\sproutbaseimport\base\FieldImporter;
use barrelstrength\sproutbaseimport\SproutBaseImport;
use barrelstrength\sproutfields\fields\Gender as GenderField;
use Craft;

class Gender extends FieldImporter
{
    /**
     * @return string
     */
    public function getModelName(): string
    {
        return GenderField::class;
    }

    /**
     * @return mixed
     */
    public function getMockData()
    {
        $nonBinary = Craft::t('sprout-fields', 'Non-Binary');
        $itsComplicated = Craft::t('sprout-fields', "It's Complicated");

        $options = [
            ['value' => 'female'],
            ['value' => 'male'],
            ['value' => 'decline'],
            ['value' => $nonBinary],
            ['value' => $itsComplicated]
        ];

        return SproutBaseImport::$app->fieldImporter->getRandomOptionValue($options);
    }
}
