<?php

namespace barrelstrength\sproutfields\integrations\sproutimport\importers\fields;

use barrelstrength\sproutbase\app\import\base\FieldImporter;
use barrelstrength\sproutfields\fields\Phone as PhoneField;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;

class Phone extends FieldImporter
{
    /**
     * @return string
     */
    public function getModelName()
    {
        return PhoneField::class;
    }

    /**
     * @return string
     */
    public function getMockData()
    {
        $settings = $this->model->settings;

        $country = $settings['country'];
        $phoneUtil = PhoneNumberUtil::getInstance();
        $exampleNumber = $phoneUtil->getExampleNumber($country);
        $national = $phoneUtil->format($exampleNumber, PhoneNumberFormat::NATIONAL);

        $phoneData = [
          'country' => $country,
          'phone' =>  $national,
          'national'  => $national
        ];

        return $phoneData;
    }
}
