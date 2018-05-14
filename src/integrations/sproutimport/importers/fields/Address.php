<?php

namespace barrelstrength\sproutfields\integrations\sproutimport\importers\fields;

use barrelstrength\sproutbase\app\import\base\FieldImporter;
use barrelstrength\sproutfields\fields\Address as AddressField;

class Address extends FieldImporter
{
    /**
     * @return string
     */
    public function getModelName()
    {
        return AddressField::class;
    }

    /**
     * @return mixed
     */
    public function getMockData()
    {
        // @todo - generate fake address
        return null;
    }
}
