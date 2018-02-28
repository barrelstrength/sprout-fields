<?php

namespace barrelstrength\sproutfields\integrations\sproutimport\fields;

use barrelstrength\sproutimport\SproutImport;
use barrelstrength\sproutbase\contracts\sproutimport\BaseFieldImporter;
use barrelstrength\sproutforms\integrations\sproutforms\fields\EmailDropdown as EmailDropdownField;

class EmailDropdown extends BaseFieldImporter
{
    /**
     * @return string
     */
    public function getModelName()
    {
        return EmailDropdownField::class;
    }

    /**
     * @return mixed
     */
    public function getMockData()
    {
        $settings = $this->model->settings;

        if (!empty($settings['options']))
        {
            return SproutImport::$app->mockData->getRandomOptionValue($settings['options']);
        }

        return null;
    }
}
