<?php

namespace barrelstrength\sproutfields\integrations\feedme;

use craft\feedme\base\Field;
use craft\feedme\base\FieldInterface;
use craft\helpers\Json;

class Phone extends Field implements FieldInterface
{
    // Properties
    // =========================================================================

    public static $name = 'Phone';
    public static $class = 'barrelstrength\sproutfields\fields\Phone';


    // Templates
    // =========================================================================

    public function getMappingTemplate()
    {
        return 'sprout-fields/feedme/phone';
       // return 'feed-me/_includes/fields/default';
    }


    // Public Methods
    // =========================================================================

    public function parseField()
    {
        $value = $this->fetchValue();

        return 'testse';
    }

}
