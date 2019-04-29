<?php

namespace barrelstrength\sproutfields\integrations\feedme;

use barrelstrength\sproutbasefields\SproutBaseFields;
use craft\feedme\base\Field;
use craft\feedme\base\FieldInterface;
use craft\helpers\Json;
use barrelstrength\sproutbasefields\models\Address as AddressModel;

class Address extends Field implements FieldInterface
{
    // Properties
    // =========================================================================

    public static $name = 'Address';
    public static $class = 'barrelstrength\sproutfields\fields\Address';


    // Templates
    // =========================================================================

    public function getMappingTemplate()
    {
        return 'sprout-fields/feedme/address';
    }


    // Public Methods
    // =========================================================================
    /**
     * @return int|null
     * @throws \yii\db\Exception
     */
    public function parseField()
    {
        $feedData = $this->feedData;

        $parsedData = [];

        $names = ['countryCode', 'address1', 'address2', 'locality',
            'administrativeAreaCode', 'postalCode'];

        foreach ($names as $name) {

            $key = 'address/' . $name;

            if (isset($feedData[$key])) {
                $parsedData[$name] = $feedData[$key];
            }
        }

        if (count($parsedData) > 0) {
            $address = new AddressModel();
            $address->elementId = $this->element->id;
            $address->siteId = $this->element->siteId;
            $address->fieldId = $this->field->id;
            $address->setAttributes($parsedData, false);

            SproutBaseFields::$app->addressField->saveAddress($address);

            return $address->id;
        }

        return null;
    }
}
