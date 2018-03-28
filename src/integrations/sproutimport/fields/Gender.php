<?php

namespace barrelstrength\sproutfields\integrations\sproutimport\fields;

use barrelstrength\sproutbase\contracts\sproutimport\BaseFieldImporter;
use barrelstrength\sproutfields\fields\Gender as GenderField;
use barrelstrength\sproutimport\SproutImport;
use Craft;

class Gender extends BaseFieldImporter
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
