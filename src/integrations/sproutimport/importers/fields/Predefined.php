<?php

namespace barrelstrength\sproutfields\integrations\sproutimport\importers\fields;

use barrelstrength\sproutbase\app\import\base\FieldImporter;
use barrelstrength\sproutfields\fields\Predefined as PredefinedField;

class Predefined extends FieldImporter
{
    /**
     * @return string
     */
    public function getModelName()
    {
        return PredefinedField::class;
    }

    /**
     * @return mixed
     */
    public function getMockData()
    {
        // Predefined field value will get generated on the onElementSave Event
        return null;
    }
}
