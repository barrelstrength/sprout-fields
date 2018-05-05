<?php

namespace barrelstrength\sproutfields\integrations\sproutimport\fields;

use barrelstrength\sproutbase\sproutimport\contracts\BaseFieldImporter;
use barrelstrength\sproutfields\fields\RegularExpression as RegularExpressionField;

class RegularExpression extends BaseFieldImporter
{
    /**
     * @return string
     */
    public function getModelName()
    {
        return RegularExpressionField::class;
    }

    /**
     * @return mixed
     */
    public function getMockData()
    {
        $settings = $this->model->settings;

        if ($settings['customPattern'] === null)
        {
            return null;
        }

        return $this->fakerService->regexify($settings['customPattern']);
    }
}
