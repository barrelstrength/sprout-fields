<?php

namespace barrelstrength\sproutfields\integrations\sproutimport\importers\fields;

use barrelstrength\sproutbase\app\import\base\FieldImporter;
use barrelstrength\sproutfields\fields\RegularExpression as RegularExpressionField;

class RegularExpression extends FieldImporter
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
