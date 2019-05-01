<?php

namespace barrelstrength\sproutfields\integrations\feedme;

use craft\feedme\base\Field;
use craft\feedme\base\FieldInterface;
use craft\helpers\Json;
use Cake\Utility\Hash;

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
    }


    // Public Methods
    // =========================================================================

    public function parseField()
    {
        $feedData = $this->feedData;

        $phone = [];

        if (isset($feedData['phone/country'])) {
            $phone['country'] = $feedData['phone/country'];
        }

        if (isset($feedData['phone/phone'])) {
            $phone['phone'] = $feedData['phone/phone'];
        }

        if (count($phone)  === 0 && !empty($this->fieldInfo['default'])) {
            $phone = $this->fieldInfo['default'];
        }

        return Json::encode($phone);
    }
}
