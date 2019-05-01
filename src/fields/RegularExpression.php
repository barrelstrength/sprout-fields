<?php

namespace barrelstrength\sproutfields\fields;

use barrelstrength\sproutbasefields\SproutBaseFields;
use Craft;
use craft\base\Element;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\base\PreviewableFieldInterface;

use barrelstrength\sproutbasefields\web\assets\regularexpression\RegularExpressionFieldAsset;
use Twig_Error_Loader;
use yii\base\Exception;
use yii\base\InvalidConfigException;

/**
 *
 * @property array $elementValidationRules
 * @property mixed $settingsHtml
 */
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
        return Craft::t('sprout-fields', 'Regular Expression (Sprout Fields)');
    }

    /**
     * @inheritdoc
     *
     * @throws Twig_Error_Loader
     * @throws Exception
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
     *
     * @throws Twig_Error_Loader
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {
        $view = Craft::$app->getView();
        $view->registerAssetBundle(RegularExpressionFieldAsset::class);

        $name = $this->handle;
        $inputId = Craft::$app->getView()->formatInputId($name);
        $namespaceInputId = Craft::$app->getView()->namespaceInputId($inputId);

        $fieldContext = SproutBaseFields::$app->utilities->getFieldContext($this, $element);

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
     * @param Element|ElementInterface $element
     *
     * @return void
     */
    public function validateRegularExpression(ElementInterface $element)
    {
        $value = $element->getFieldValue($this->handle);

        if (!SproutBaseFields::$app->regularExpressionField->validate($value, $this)) {
            $element->addError(
                $this->handle,
                SproutBaseFields::$app->regularExpressionField->getErrorMessage($this)
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
