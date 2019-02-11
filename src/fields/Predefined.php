<?php

namespace barrelstrength\sproutfields\fields;

use barrelstrength\sproutbase\SproutBase;
use Craft;
use craft\base\Element;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\base\PreviewableFieldInterface;
use yii\db\Schema;

/**
 *
 * @property string $contentColumnType
 * @property mixed  $settingsHtml
 */
class Predefined extends Field implements PreviewableFieldInterface
{
    /**
     * @var string
     */
    public $fieldFormat;

    /**
     * @var bool
     */
    public $showField;

    /**
     * @var bool
     */
    public $outputTextarea;

    /**
     * @return string
     */
    public static function displayName(): string
    {
        return Craft::t('sprout-fields', 'Predefined (Sprout Fields)');
    }

    /**
     * @inheritdoc
     */
    public function getContentColumnType(): string
    {
        return Schema::TYPE_TEXT;
    }

    /**
     * @inheritdoc
     *
     * @throws \Twig_Error_Loader
     * @throws \yii\base\Exception
     */
    public function getSettingsHtml()
    {
        return Craft::$app->getView()->renderTemplate('sprout-base-fields/_components/fields/formfields/predefined/settings',
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
        return Craft::$app->getView()->renderTemplate('sprout-base-fields/_components/fields/formfields/predefined/input',
            [
                'id' => $this->handle,
                'name' => $this->handle,
                'value' => $value,
                'field' => $this
            ]);
    }

    /**
     * @param Element $element
     * @param bool $isNew
     *
     * @throws \Throwable
     */
    public function processFieldValues($element, $isNew)
    {
        if ($isNew) {
            // If this is a new Element, grab the Element from the database to ensure
            // we have all IDs from other Elements like Matrix Blocks
            $element = Craft::$app->elements->getElementById($element->id);
        }

        try {
            $value = Craft::$app->view->renderObjectTemplate($this->fieldFormat, $element);

            $fieldColumnPrefix = $element->getFieldColumnPrefix();
            $column = $fieldColumnPrefix.$this->handle;

            Craft::$app->db->createCommand()->update($element->contentTable, [
                $column => $value,
            ], 'elementId=:elementId AND siteId=:siteId', [
                ':elementId' => $element->id,
                ':siteId' => $element->siteId
            ])
                ->execute();
        } catch (\Exception $e) {
            SproutBase::error($e->getMessage());
        }
    }
}
