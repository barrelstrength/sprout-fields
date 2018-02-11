<?php

namespace barrelstrength\sproutfields\fields;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;

use barrelstrength\sproutfields\SproutFields;

class Gender extends Field
{

    /**
     * @var text
     */
    public $genderOptions;

    public static function displayName(): string
    {
        return SproutFields::t('Gender (Sprout)');
    }

    /**
     * Define database column
     *
     * @return false
     */
    public function defineContentAttribute()
    {
        // field type doesn’t need its own column
        // in the content table, return false
        return false;
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml()
    {
        $name = $this->displayName();

        $inputId = Craft::$app->getView()->formatInputId($name);
        $namespaceInputId = Craft::$app->getView()->namespaceInputId($inputId);

        return Craft::$app->getView()->renderTemplate(
            'sprout-fields/_fieldtypes/gender/settings',
            [
                'id' => $namespaceInputId,
                'name' => $name,
                'field' => $this,
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {
        $name = $this->handle;
        $inputId = Craft::$app->getView()->formatInputId($name);
        $namespaceInputId = Craft::$app->getView()->namespaceInputId($inputId);
        $genderOptions = $this->getGenderOptions($value);

        return Craft::$app->getView()->renderTemplate(
            'sprout-base/sproutfields/_includes/forms/gender/input',
            [
                'id' => $namespaceInputId,
                'name' => $name,
                'field' => $this,
                'value' => $value,
                'genderOptions' => $genderOptions
            ]
        );
    }

    /**
     * @return array
     */
    private function getGenderOptions($value)
    {
        $options = [
            [
                'label' => Craft::t('sprout-fields','Select...'),
                'value' => ''
            ],
            [
                'label' => Craft::t('sprout-fields','Female'),
                'value' => 'female'
            ],
            [
                'label' => Craft::t('sprout-fields','Male'),
                'value' => 'male',
            ],
            [
                'label' => Craft::t('sprout-fields','Prefer Not to Say'),
                'value' => 'decline'
            ]
        ];

        $gender = $value ?? null;

        array_push($options, ['optgroup' => Craft::t('sprout-fields','Custom')]);

        if (!array_key_exists($gender, ['female' => 0, 'male' => 1, 'decline' => 2]) && $gender != '') {
            array_push($options, ['label' => $gender, 'value' => $gender]);
        }

        array_push($options, ['label' => Craft::t('sprout-fields','Add Custom'), 'value' => 'custom']);

        return $options;
    }
}
