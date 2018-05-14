<?php

namespace barrelstrength\sproutfields\fields;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\base\PreviewableFieldInterface;

use barrelstrength\sproutfields\SproutFields;
use barrelstrength\sproutbase\SproutBase;

class Url extends Field implements PreviewableFieldInterface
{
    /**
     * @var string|null
     */
    public $customPatternErrorMessage;

    /**
     * @var bool|null
     */
    public $customPatternToggle;

    /**
     * @var string|null
     */
    public $customPattern;

    /**
     * @var string|null
     */
    public $placeholder;

    public static function displayName(): string
    {
        return SproutFields::t('URL (Sprout)');
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml()
    {
        return Craft::$app->getView()->renderTemplate(
            'sprout-base-fields/_components/fields/formfields/url/settings',
            [
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

        $fieldContext = SproutBase::$app->utilities->getFieldContext($this, $element);

        return Craft::$app->getView()->renderTemplate('sprout-base-fields/_components/fields/formfields/url/input', [
                'namespaceInputId' => $namespaceInputId,
                'id' => $inputId,
                'name' => $name,
                'value' => $value,
                'fieldContext' => $fieldContext,
                'placeholder' => $this->placeholder
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function getElementValidationRules(): array
    {
        $rules = parent::getElementValidationRules();
        $rules[] = 'validateUrl';

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
    public function validateUrl(ElementInterface $element)
    {
        $value = $element->getFieldValue($this->handle);

        if (!SproutBase::$app->urlField->validate($value, $this)) {
            $element->addError(
                $this->handle,
                SproutBase::$app->urlField->getErrorMessage($this->name, $this)
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
            $html = '<a href="'.$value.'" target="_blank">'.$value.'</a>';
        }

        return $html;
    }
}
