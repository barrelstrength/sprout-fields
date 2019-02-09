<?php

namespace barrelstrength\sproutfields\integrations\sproutimport\importers\fields;

use barrelstrength\sproutbaseimport\base\FieldImporter;
use barrelstrength\sproutfields\fields\Predefined as PredefinedField;

class Predefined extends FieldImporter
{
    /**
     * @return string
     */
    public function getModelName(): string
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
