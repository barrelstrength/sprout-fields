<?php
/**
 * @link https://sprout.barrelstrengthdesign.com
 * @copyright Copyright (c) Barrel Strength Design LLC
 * @license https://craftcms.github.io/license
 */

namespace barrelstrength\sproutfields\integrations\sproutimport\importers\fields;

use barrelstrength\sproutbaseimport\base\FieldImporter;
use barrelstrength\sproutfields\fields\Phone as PhoneField;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;

class Phone extends FieldImporter
{
    /**
     * @return string
     */
    public function getModelName(): string
    {
        return PhoneField::class;
    }

    /**
     * @return array
     */
    public function getMockData(): array
    {
        $settings = $this->model->settings;

        $country = $settings['country'];
        $phoneUtil = PhoneNumberUtil::getInstance();
        $exampleNumber = $phoneUtil->getExampleNumber($country);
        $national = $phoneUtil->format($exampleNumber, PhoneNumberFormat::NATIONAL);

        $phoneData = [
            'country' => $country,
            'phone' => $national,
            'national' => $national
        ];

        return $phoneData;
    }
}
