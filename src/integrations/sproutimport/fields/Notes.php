<?php

namespace barrelstrength\sproutfields\integrations\sproutimport\fields;

use barrelstrength\sproutbase\contracts\sproutimport\BaseFieldImporter;
use barrelstrength\sproutfields\fields\Notes as NotesField;

class Notes extends BaseFieldImporter
{
    /**
     * @return string
     */
    public function getModelName()
    {
        return NotesField::class;
    }

    /**
     * @return mixed
     */
    public function getMockData()
    {
        // No fake data needed. Value is provided from field settings.
        return null;
    }
}
