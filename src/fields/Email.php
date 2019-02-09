<?php

namespace barrelstrength\sproutfields\fields;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\base\PreviewableFieldInterface;

use barrelstrength\sproutfields\SproutFields;
use barrelstrength\sproutbase\SproutBase;

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
        return SproutFields::t('Email (Sprout Fields)');
    }

    /**
     * @inheritdoc
     *
     * @throws \Twig_Error_Loader
     * @throws \yii\base\Exception
     */
    public function getSettingsHtml()
    {
        return Craft::$app->getView()->renderTemplate('sprout-base-fields/_components/fields/formfields/email/settings',
            [
                'field' => $this,
            ]);
    }

    /**
     * @inheritdoc
     *
     * @throws \Twig_Error_Loader
     * @throws \yii\base\Exception
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {
        $name = $this->handle;
        $inputId = Craft::$app->getView()->formatInputId($name);
        $namespaceInputId = Craft::$app->getView()->namespaceInputId($inputId);

        $fieldContext = SproutBaseFields::$app->utilities->getFieldContext($this, $element);

        // Set this to false for Quick Entry Dashboard Widget
        $elementId = ($element != null) ? $element->id : false;

        return Craft::$app->getView()->renderTemplate('sprout-base-fields/_components/fields/formfields/email/input',
            [
                'namespaceInputId' => $namespaceInputId,
                'id' => $inputId,
                'name' => $name,
                'value' => $value,
                'elementId' => $elementId,
                'fieldContext' => $fieldContext,
                'placeholder' => $this->placeholder
            ]);
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
     * @param ElementInterface $element
     *
     * @return void
     */
    public function validateEmail(ElementInterface $element)
    {
        $value = $element->getFieldValue($this->handle);

        $customPattern = $this->customPattern;
        $checkPattern = $this->customPatternToggle;

        if (!SproutBaseFields::$app->emailField->validateEmailAddress($value, $customPattern, $checkPattern)) {
            $element->addError($this->handle,
                SproutBaseFields::$app->emailField->getErrorMessage(
                    $this->name, $this)
            );
        }

        $uniqueEmail = $this->uniqueEmail;

        if ($uniqueEmail && !SproutBaseFields::$app->emailField->validateUniqueEmailAddress($value, $element, $this)) {
            $element->addError($this->handle,
                SproutFields::t($this->name.' must be a unique email.')
            );
        }
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
