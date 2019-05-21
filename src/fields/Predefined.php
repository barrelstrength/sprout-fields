<?php

namespace barrelstrength\sproutfields\fields;

use barrelstrength\sproutbase\SproutBase;
use Craft;
use craft\base\Element;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\base\PreviewableFieldInterface;
use Exception;
use Throwable;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
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
     * @var string
     */
    public $contentColumnType;

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
        return $this->contentColumnType ?? Schema::TYPE_TEXT;
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
        $contentColumnOptions = [
            [
                'label' => 'Plain Text',
                'value' => Schema::TYPE_TEXT
            ],
            [
                'label' => 'Date',
                'value' => Schema::TYPE_DATETIME
            ]
        ];

        return Craft::$app->getView()->renderTemplate('sprout-base-fields/_components/fields/formfields/predefined/settings',
            [
                'field' => $this,
                'contentColumnOptions' => $contentColumnOptions
            ]);
    }

    /**
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
     * @param bool    $isNew
     *
     * @throws Throwable
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

            Craft::$app->db->createCommand()
                ->update(
                    $element->contentTable,
                    [$column => $value],
                    [
                        'and',
                        ['elementId' => $element->id],
                        ['siteId' => $element->siteId]
                    ])
                ->execute();
        } catch (Exception $e) {
            Craft::$app->getSession()->setError(Craft::t('sprout-base-fields', 'Error processing Predefined Field: {name}.', [
                'name' => $this->name
            ]));
            SproutBase::error($e->getMessage());
        }
    }
}
