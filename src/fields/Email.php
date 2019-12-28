<?php

namespace barrelstrength\sproutfields\fields;

use barrelstrength\sproutbasefields\SproutBaseFields;
use Craft;
use craft\base\Element;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\base\PreviewableFieldInterface;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 *
 * @property array $elementValidationRules
 * @property mixed $settingsHtml
 */
class Email extends Field implements PreviewableFieldInterface
{
    /**
     * @var string|null
     */
    public $customPattern;

    /**
     * @var bool
     */
    public $customPatternToggle;

    /**
     * @var string|null
     */
    public $customPatternErrorMessage;

    /**
     * @var bool
     */
    public $uniqueEmail;

    /**
     * @var string|null
     */
    public $placeholder;

    public static function displayName(): string
    {
        return Craft::t('sprout-fields', 'Email (Sprout Fields)');
    }

    /**
     * @return string|null
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function getSettingsHtml()
    {
        return SproutBaseFields::$app->emailField->getSettingsHtml($this);
    }

    /**
     * @param                               $value
     * @param Element|ElementInterface|null $element
     *
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {
        return SproutBaseFields::$app->emailField->getInputHtml($this, $value, $element);
    }

    /**
     * @inheritdoc
     */
    public function getElementValidationRules(): array
    {
        $rules = parent::getElementValidationRules();
        $rules[] = 'validateEmail';

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
    public function validateEmail(ElementInterface $element)
    {
        $value = $element->getFieldValue($this->handle);
        SproutBaseFields::$app->emailField->validate($value, $this, $element);
    }

    /**
     * @inheritdoc
     */
    public function getTableAttributeHtml($value, ElementInterface $element): string
    {
        $html = '';

        if ($value) {
            $html = '<a href="mailto:'.$value.'" target="_blank">'.$value.'</a>';
        }

        return $html;
    }
}
