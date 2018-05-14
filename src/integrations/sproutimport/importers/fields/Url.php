<?php

namespace barrelstrength\sproutfields\integrations\sproutimport\importers\fields;

use barrelstrength\sproutbase\app\import\base\FieldImporter;
use barrelstrength\sproutfields\fields\Url as UrlField;

class Url extends FieldImporter
{
    /**
     * @return string
     */
    public function getModelName()
    {
        return UrlField::class;
    }

    /**
     * @return mixed
     */
    public function getMockData()
    {
        $settings = $this->model->settings;

        // We cannot support regexes, as they may allow infinite characters such as (.*)
        if (!empty($settings['customPatternToggle']) && !empty($settings['customPattern']))
        {
            return null;
        }

        return $this->fakerService->url;
    }
}
