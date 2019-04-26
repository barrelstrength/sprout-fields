<?php

namespace barrelstrength\sproutfields\integrations\feedme;

use craft\feedme\base\Field;
use craft\feedme\base\FieldInterface;
use craft\helpers\Json;
use Craft;

class RegularExpression extends Field implements FieldInterface
{
    // Properties
    // =========================================================================

    public static $name = 'RegularExpression';
    public static $class = 'barrelstrength\sproutfields\fields\RegularExpression';


    // Templates
    // =========================================================================

    public function getMappingTemplate()
    {
        return 'feed-me/_includes/fields/default';
    }


    // Public Methods
    // =========================================================================

    public function parseField()
    {
        $feedData = $this->feedData;

        $fieldsService = Craft::$app->getFields();

        $value = $feedData['regularExpression/value'] ?? '';

        if ($this->field->settings) {

            if (isset($feedData['regularExpression/setting/customPattern'])) {
                $pattern = $feedData['regularExpression/setting/customPattern'];
                $this->field->customPattern = $pattern;

                $fieldsService->saveField($this->field);
            }
        }

        return $value;
    }
}
