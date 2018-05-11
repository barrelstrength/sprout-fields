<?php

namespace barrelstrength\sproutfields\integrations\sproutimport\fields;

use barrelstrength\sproutbase\app\import\contracts\BaseFieldImporter;
use barrelstrength\sproutfields\fields\Url as UrlField;

class Url extends BaseFieldImporter
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
