<?php

namespace barrelstrength\sproutfields\integrations\sproutimport\importers\fields;

use barrelstrength\sproutbase\app\import\base\FieldImporter;
use barrelstrength\sproutfields\fields\Gender as GenderField;
use barrelstrength\sproutimport\SproutImport;
use Craft;

class Gender extends FieldImporter
{
    /**
     * @return string
     */
    public function getModelName()
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
            [ 'value' => 'female' ],
            [ 'value' => 'male' ],
            [ 'value' => 'decline' ],
            [ 'value' => $nonBinary ],
            [ 'value' => $itsComplicated ]
        ];

        return SproutImport::$app->fieldImporter->getRandomOptionValue($options);
    }
}
