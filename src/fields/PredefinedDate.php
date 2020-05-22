<?php

namespace barrelstrength\sproutfields\fields;

use Craft;
use craft\base\ElementInterface;
use craft\helpers\DateTimeHelper;
use craft\i18n\Locale;
use Exception;
use Throwable;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use yii\db\Schema;

/**
 * @property string $contentColumnType
 * @property mixed  $settingsHtml
 */
class PredefinedDate extends BasePredefinedField
{
    /**
     * @inheritDoc
     */
    public static function displayName(): string
    {
        return Craft::t('sprout-fields', 'Predefined Date (Sprout Fields)');
    }

    /**
     * @inheritDoc
     */
    public function getContentColumnType(): string
    {
        return Schema::TYPE_DATETIME;
    }

    /**
     * @inheritDoc
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws \yii\base\Exception
     */
    public function getSettingsHtml()
    {
        return Craft::$app->getView()->renderTemplate('sprout-base-fields/_components/fields/formfields/predefineddate/settings',
            [
                'field' => $this
            ]);
    }

    /**
     * @inheritDoc
     *
     * @throws Exception
     */
    public function normalizeValue($value, ElementInterface $element = null)
    {
        if ($value && ($date = DateTimeHelper::toDateTime($value)) !== false) {
            return $date;
        }

        return null;
    }

    /**
     * @param                       $value
     * @param ElementInterface|null $element
     *
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws Throwable
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {
        return Craft::$app->getView()->renderTemplate('sprout-base-fields/_components/fields/formfields/predefineddate/input',
            [
                'field' => $this,
                'name' => $this->handle,
                'value' => $value
            ]);
    }

    /**
     * @inheritdoc
     */
    public function getTableAttributeHtml($value, ElementInterface $element): string
    {
        if ($value) {
            $formatter = Craft::$app->getFormatter();

            /** @var DateTime $value */
            return '<span title="' . $formatter->asDatetime($value, Locale::LENGTH_SHORT) . '">' . $formatter->asTimestamp($value, Locale::LENGTH_FULL) . '</span>';
        }

        return '';
    }
}
