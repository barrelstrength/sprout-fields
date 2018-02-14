<?php

namespace barrelstrength\sproutfields\integrations\sproutimport\fields;

use barrelstrength\sproutbase\contracts\sproutimport\BaseFieldImporter;
use barrelstrength\sproutbase\SproutBase;
use barrelstrength\sproutfields\fields\Phone as PhoneField;

class Phone extends BaseFieldImporter
{
    /**
     * @return string
     */
    public function getModelName()
    {
        return PhoneField::class;
    }

    /**
     * @return mixed
     */
    public function getMockData()
    {
        $settings = $this->model->settings;
        $mask     = '';

        // We cannot support regexes, as they may allow infinite characters such as (.*)
        if (!empty($settings['customPatternToggle']) && !empty($settings['mask']))
        {
            $mask = $settings['mask'];
        }
        else
        {
            $mask = SproutBase::$app->phone->getDefaultMask();
        }

        return $this->convertMaskToFakePhoneNumber($mask);
    }

    /**
     * @param $mask
     *
     * @return string
     */
    public function convertMaskToFakePhoneNumber($mask)
    {
        $phoneNumber = "";
        $length      = strlen($mask);

        for ($i = 0; $i <= $length; $i++)
        {
            $currentCharacter = substr($mask, $i, 1);

            // Generate a fake number for each hash character
            // Keep the rest of the characters the same
            if ($currentCharacter == '#')
            {
                $randomNumber = ($i == 0)
                    ? $this->fakerService->numberBetween(1, 9)
                    : $this->fakerService->numberBetween(0, 9);

                $phoneNumber .= $randomNumber;
            }
            else
            {
                $phoneNumber .= $currentCharacter;
            }
        }

        return $phoneNumber;
    }
}
