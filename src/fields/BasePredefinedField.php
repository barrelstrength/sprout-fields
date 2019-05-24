<?php

namespace barrelstrength\sproutfields\fields;

use barrelstrength\sproutbase\SproutBase;
use Craft;
use craft\base\Element;
use craft\base\Field;
use craft\base\PreviewableFieldInterface;
use Exception;
use Throwable;

/**
 * @property mixed $settingsHtml
 */
class BasePredefinedField extends Field implements PreviewableFieldInterface
{
    /**
     * The code that will be processed to generate the Predefined Field value
     *
     * @var string
     */
    public $fieldFormat;

    /**
     * Whether to display the field and its value in the Field Layout
     *
     * @var bool
     */
    public $showField;

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
