<?php

namespace barrelstrength\sproutfields\integrations\sproutimport\importers\fields;

use barrelstrength\sproutbaseimport\base\FieldImporter;
use barrelstrength\sproutfields\fields\Notes as NotesField;

class Notes extends FieldImporter
{
    /**
     * @return string
     */
    public function getModelName(): string
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
