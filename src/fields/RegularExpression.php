<?php

namespace barrelstrength\sproutfields\fields;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\base\PreviewableFieldInterface;

use barrelstrength\sproutfields\SproutFields;
use barrelstrength\sproutbase\SproutBase;
use barrelstrength\sproutbase\app\fields\web\assets\regularexpression\RegularExpressionFieldAsset;

class RegularExpression extends Field implements PreviewableFieldInterface
{
    /**
     * @var string
     */
    public $customPatternErrorMessage;

    /**
     * @var string
     */
    public $customPattern;

    /**
     * @var string
     */
    public $placeholder;

    /**
     * @return string
     */
    public static function displayName(): string
    {
        return SproutFields::t('Regular Expression (Sprout)');
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml()
    {
        return Craft::$app->getView()->renderTemplate(
            'sprout-base-fields/_components/fields/formfields/regularexpression/settings',
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
        $view = Craft::$app->getView();
        $view->registerAssetBundle(RegularExpressionFieldAsset::class);

        $name = $this->handle;
        $inputId = Craft::$app->getView()->formatInputId($name);
        $namespaceInputId = Craft::$app->getView()->namespaceInputId($inputId);

        $fieldContext = SproutBase::$app->utilities->getFieldContext($this, $element);

        return Craft::$app->getView()->renderTemplate(
            'sprout-base-fields/_components/fields/formfields/regularexpression/input',
            [
                'id' => $namespaceInputId,
                'field' => $this,
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
        $rules[] = 'validateRegularExpression';

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
    public function validateRegularExpression(ElementInterface $element)
    {
        $value = $element->getFieldValue($this->handle);

        if (!SproutBase::$app->regularExpressionField->validate($value, $this)) {
            $element->addError(
                $this->handle,
                SproutBase::$app->regularExpressionField->getErrorMessage($this)
            );
        }
    }

    /**
     * @inheritdoc
     */
    public function getTableAttributeHtml($value, ElementInterface $element): string
    {
        return $value;
    }
}
