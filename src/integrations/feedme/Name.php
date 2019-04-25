<?php

namespace barrelstrength\sproutfields\integrations\feedme;

use craft\feedme\base\Field;
use craft\feedme\base\FieldInterface;
use craft\helpers\Json;

class Name extends Field implements FieldInterface
{
    // Properties
    // =========================================================================

    public static $name = 'Phone';
    public static $class = 'barrelstrength\sproutfields\fields\Name';


    // Templates
    // =========================================================================

    public function getMappingTemplate()
    {
        return 'sprout-fields/feedme/name';
    }


    // Public Methods
    // =========================================================================

    public function parseField()
    {
        $feedData = $this->feedData;

        $parsedData = [];

        $names = ['prefix', 'firstName', 'middleName', 'lastName', 'suffix'];

        foreach ($names as $name) {

            $key = 'name/' . $name;

            if (isset($feedData[$key])) {
                $parsedData[$name] = $feedData[$key];
            }
        }

        return Json::encode($parsedData);
    }
}
