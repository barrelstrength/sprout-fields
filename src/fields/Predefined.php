<?php

namespace barrelstrength\sproutfields\fields;

use barrelstrength\sproutbase\SproutBase;
use barrelstrength\sproutfields\SproutFields;
use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\base\PreviewableFieldInterface;
use yii\db\Schema;

class Predefined extends Field implements PreviewableFieldInterface
{
    /**
     * @var string|null The maximum allowed number
     */
    public $value;

    public static function displayName(): string
    {
        return SproutFields::t('Predefined');
    }

    /**
     * @inheritdoc
     */
    public function getContentColumnType(): string
    {
        return Schema::TYPE_STRING;
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml()
    {
        return Craft::$app->getView()->renderTemplate('sprout-fields/_fieldtypes/predefined/settings',
            [
                'field' => $this,
            ]);
    }

    /**
     * @param                       $value
     * @param ElementInterface|null $element
     *
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \yii\base\Exception
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {
        return Craft::$app->getView()->renderTemplate('sprout-base/sproutfields/_includes/forms/predefined/input',
            [
                'id' => $this->handle,
                'name' => $this->handle,
                'value' => $value,
                'field' => $this
            ]);
    }

    /**
     * @param ElementInterface $element
     * @param bool             $isNew
     */
    public function afterElementSave(ElementInterface $element, bool $isNew)
    {
        parent::afterElementSave($element, $isNew);

        SproutBase::$app->utilities->processPredefinedField($this, $element);
    }
}
