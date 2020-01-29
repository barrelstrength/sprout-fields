<?php
/**
 * @link https://sprout.barrelstrengthdesign.com
 * @copyright Copyright (c) Barrel Strength Design LLC
 * @license https://craftcms.github.io/license
 */

namespace barrelstrength\sproutfields\fields;

use barrelstrength\sproutbasefields\models\Phone as PhoneModel;
use barrelstrength\sproutbasefields\SproutBaseFields;
use Craft;
use craft\base\Element;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\base\PreviewableFieldInterface;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use yii\db\Schema;

/**
 *
 * @property array  $elementValidationRules
 * @property string $contentColumnType
 * @property mixed  $settingsHtml
 * @property array  $countries
 */
class Phone extends Field implements PreviewableFieldInterface
{
    /**
     * @var string|null
     */
    public $customPatternErrorMessage;

    /**
     * @var bool|null
     */
    public $limitToSingleCountry;

    /**
     * @var string|null
     */
    public $country;

    /**
     * @var string|null
     */
    public $placeholder;

    /**
     * @var string|null
     */
    public $customPatternToggle;

    public $mask;

    public $inputMask;

    public static function displayName(): string
    {
        return Craft::t('sprout-fields', 'Phone (Sprout Fields)');
    }

    /**
     * @inheritdoc
     */
    public function getContentColumnType(): string
    {
        return Schema::TYPE_TEXT;
    }

    /**
     * @param                       $value
     * @param ElementInterface|null $element
     *
     * @return PhoneModel|mixed|null
     */
    public function normalizeValue($value, ElementInterface $element = null)
    {
        return SproutBaseFields::$app->phoneField->normalizeValue($this, $value, $element);
    }

    /**
     * @param                       $value
     *
     * @param ElementInterface|null $element
     *
     * @return array|mixed|string|null
     */
    public function serializeValue($value, ElementInterface $element = null)
    {
        $value = SproutBaseFields::$app->phoneField->serializeValue($value);

        return parent::serializeValue($value, $element);
    }

    /**
     * @inheritdoc
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function getSettingsHtml()
    {
        return SproutBaseFields::$app->phoneField->getSettingsHtml($this);
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
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {
        return SproutBaseFields::$app->phoneField->getInputHtml($this, $value);
    }

    /**
     * @inheritdoc
     */
    public function getElementValidationRules(): array
    {
        $rules = parent::getElementValidationRules();
        $rules[] = 'validatePhone';

        return $rules;
    }

    /**
     * Validates our fields submitted value beyond the checks
     * that were assumed based on the content attribute.
     *
     *
     * @param Element|ElementInterface $element
     *
     * @return void
     */
    public function validatePhone(ElementInterface $element)
    {
        $value = $element->getFieldValue($this->handle);

        // Don't run validation if a field is not required and has no value for the phone number
        if (!$this->required && empty($value->phone)) {
            return;
        }

        $isValid = SproutBaseFields::$app->phoneField->validate($value);

        if (!$isValid) {
            $message = SproutBaseFields::$app->phoneField->getErrorMessage($this, $value->country);
            $element->addError($this->handle, $message);
        }
    }

    /**
     * @inheritdoc
     */
    public function getTableAttributeHtml($value, ElementInterface $element): string
    {
        $html = '';

        if ($value->international) {
            $fullNumber = $value->international;
            $html = '<a href="tel:'.$fullNumber.'" target="_blank">'.$fullNumber.'</a>';
        }

        return $html;
    }
}
