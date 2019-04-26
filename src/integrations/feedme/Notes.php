<?php

namespace barrelstrength\sproutfields\integrations\feedme;

use craft\feedme\base\Field;
use craft\feedme\base\FieldInterface;
use Craft;

class Notes extends Field implements FieldInterface
{
    // Properties
    // =========================================================================

    public static $name = 'Notes';
    public static $class = 'barrelstrength\sproutfields\fields\Notes';


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
        $value = $this->fetchValue();

        $fieldsService = Craft::$app->getFields();

        if ($this->field->settings) {

            if ($value != '') {
                $this->field->notes = $value;

                $fieldsService->saveField($this->field);
            }
        }

        return $value;
    }
}
