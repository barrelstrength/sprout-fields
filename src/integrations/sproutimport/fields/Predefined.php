<?php

namespace barrelstrength\sproutfields\integrations\sproutimport\fields;

use barrelstrength\sproutbase\app\import\contracts\BaseFieldImporter;
use barrelstrength\sproutfields\fields\Predefined as PredefinedField;

class Predefined extends BaseFieldImporter
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
