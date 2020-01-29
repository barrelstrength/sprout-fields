<?php
/**
 * @link https://sprout.barrelstrengthdesign.com
 * @copyright Copyright (c) Barrel Strength Design LLC
 * @license https://craftcms.github.io/license
 */

namespace barrelstrength\sproutfields\fields;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class Gender extends Field
{
    /**
     * @var array
     */
    public $genderOptions;

    /**
     * @return string
     */
    public static function displayName(): string
    {
        return Craft::t('sprout-fields', 'Gender (Sprout Fields)');
    }

    /**
     * Define database column
     *
     * @return false
     */
    public function defineContentAttribute(): bool
    {
        // field type doesn’t need its own column
        // in the content table, return false
        return false;
    }

    /**
     * @inheritdoc
     *
     * @param                       $value
     * @param ElementInterface|null $element
     *
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws \yii\base\Exception
     * @throws \yii\base\Exception
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {
        $name = $this->handle;
        $inputId = Craft::$app->getView()->formatInputId($name);
        $namespaceInputId = Craft::$app->getView()->namespaceInputId($inputId);
        $genderOptions = $this->getGenderOptions($value);

        return Craft::$app->getView()->renderTemplate('sprout-base-fields/_components/fields/formfields/gender/input',
            [
                'id' => $namespaceInputId,
                'field' => $this,
                'genderOptions' => $genderOptions,
                'name' => $name,
                'value' => $value
            ]
        );
    }

    /**
     * @param $value
     *
     * @return array
     */
    private function getGenderOptions($value): array
    {
        $options = [
            [
                'label' => Craft::t('sprout-fields', 'Select...'),
                'value' => ''
            ],
            [
                'label' => Craft::t('sprout-fields', 'Female'),
                'value' => 'female'
            ],
            [
                'label' => Craft::t('sprout-fields', 'Male'),
                'value' => 'male',
            ],
            [
                'label' => Craft::t('sprout-fields', 'Prefer not to say'),
                'value' => 'decline'
            ]
        ];

        $gender = $value ?? null;

        $options[] = [
            'optgroup' => Craft::t('sprout-fields', 'Custom')
        ];

        if (!array_key_exists($gender, ['female' => 0, 'male' => 1, 'decline' => 2]) && $gender != '') {
            $options[] = [
                'label' => $gender,
                'value' => $gender
            ];
        }

        $options[] = [
            'label' => Craft::t('sprout-fields', 'Add Custom'),
            'value' => 'custom'
        ];

        return $options;
    }
}
