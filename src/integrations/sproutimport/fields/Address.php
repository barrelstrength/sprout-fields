<?php

namespace barrelstrength\sproutfields\integrations\sproutimport\fields;

use barrelstrength\sproutbase\sproutimport\contracts\BaseFieldImporter;
use barrelstrength\sproutfields\fields\Address as AddressField;

class Address extends BaseFieldImporter
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
