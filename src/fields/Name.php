<?php

namespace barrelstrength\sproutfields\fields;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\base\PreviewableFieldInterface;

use barrelstrength\sproutbasefields\models\Name as NameModel;
use craft\helpers\Json;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 *
 * @property mixed $settingsHtml
 */
class Name extends Field implements PreviewableFieldInterface
{
    /**
     * @var bool
     */
    public $displayMultipleFields;

    /**
     * @var bool
     */
    public $displayMiddleName;

    /**
     * @var bool
     */
    public $displayPrefix;

    /**
     * @var bool
     */
    public $displaySuffix;

    public static function displayName(): string
    {
        return Craft::t('sprout-fields', 'Name (Sprout Fields)');
    }

    /**
     * @inheritdoc
     *\
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function getSettingsHtml()
    {
        return Craft::$app->getView()->renderTemplate(
            'sprout-base-fields/_components/fields/formfields/name/settings',
            [
                'field' => $this,
            ]);
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
        $name = $this->handle;
        $inputId = Craft::$app->getView()->formatInputId($name);
        $namespaceInputId = Craft::$app->getView()->namespaceInputId($inputId);

        return Craft::$app->getView()->renderTemplate(
            'sprout-base-fields/_components/fields/formfields/name/input',
            [
                'namespaceInputId' => $namespaceInputId,
                'id' => $inputId,
                'name' => $name,
                'value' => $value,
                'field' => $this
            ]);
    }

    /**
     * Prepare our Name for use as an NameModel
     *
     * @param                       $value
     * @param ElementInterface|null $element
     *
     * @return NameModel|mixed
     * @todo - move to helper as we can use this on both Sprout Forms and Sprout Fields
     *
     */
    public function normalizeValue($value, ElementInterface $element = null)
    {
        $nameModel = new NameModel();

        // String value when retrieved from db
        if (is_string($value)) {
            $nameArray = Json::decode($value);
            $nameModel->setAttributes($nameArray, false);
            return $nameModel;
        }

        // Array value from post data
        if (is_array($value) && isset($value['address'])) {

            $nameModel->setAttributes($value['address'], false);

            if ($fullNameShort = $value['address']['fullNameShort'] ?? null) {
                $nameArray = explode(' ', trim($fullNameShort));

                $nameModel->firstName = $nameArray[0] ?? $fullNameShort;
                unset($nameArray[0]);

                $nameModel->lastName = implode(' ', $nameArray);
            }
            return $nameModel;
        }

        return $value;
    }

    /**
     * Prepare the field value for the database.
     *
     * @param NameModel             $value
     * @param ElementInterface|null $element
     *
     * @return array|bool|mixed|null|string
     * @todo - move to helper as we can use this on both Sprout Forms and Sprout Fields
     *
     * We store the Name as JSON in the content column.
     *
     */
    public function serializeValue($value, ElementInterface $element = null)
    {
        if ($value === null) {
            return false;
        }

        // Submitting an Element to be saved
        if (is_object($value) && get_class($value) == NameModel::class) {
            return Json::encode($value->getAttributes());
        }

        return $value;
    }

    /**
     * @inheritdoc
     */
    public function getTableAttributeHtml($value, ElementInterface $element): string
    {
        $html = '';

        if ($value) {
            /** @var NameModel $value */
            $html = $value->getFullName();
        }

        return $html;
    }
}
