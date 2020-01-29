<?php
/**
 * @link https://sprout.barrelstrengthdesign.com
 * @copyright Copyright (c) Barrel Strength Design LLC
 * @license https://craftcms.github.io/license
 */

namespace barrelstrength\sproutfields\integrations\sproutimport\importers\fields;

use barrelstrength\sproutbaseimport\base\FieldImporter;
use barrelstrength\sproutfields\fields\Address as AddressField;

class Address extends FieldImporter
{
    /**
     * @return string
     */
    public function getModelName(): string
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
