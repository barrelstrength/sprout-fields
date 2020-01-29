<?php
/**
 * @link https://sprout.barrelstrengthdesign.com
 * @copyright Copyright (c) Barrel Strength Design LLC
 * @license https://craftcms.github.io/license
 */

namespace barrelstrength\sproutfields\fields;

use barrelstrength\sproutbasefields\base\AddressFieldTrait;
use barrelstrength\sproutbasefields\models\Address as AddressModel;
use barrelstrength\sproutbasefields\SproutBaseFields;
use CommerceGuys\Addressing\Address as CommerceGuysAddress;
use CommerceGuys\Addressing\AddressFormat\AddressFormatRepository;
use CommerceGuys\Addressing\Country\CountryRepository;
use CommerceGuys\Addressing\Formatter\DefaultFormatter;
use CommerceGuys\Addressing\Subdivision\SubdivisionRepository;
use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\base\PreviewableFieldInterface;
use craft\errors\SiteNotFoundException;
use Throwable;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use yii\db\Exception;
use yii\db\StaleObjectException;

/**
 * Class Address
 *
 * @package barrelstrength\sproutfields\fields
 *
 * @property array       $elementValidationRules
 * @property null|string $settingsHtml
 * @property string      $contentColumnType
 */
class Address extends Field implements PreviewableFieldInterface
{
    use AddressFieldTrait;

    /**
     * @var string|null
     */
    public $value;

    public static function supportedTranslationMethods(): array
    {
        return [
            self::TRANSLATION_METHOD_NONE,
            self::TRANSLATION_METHOD_SITE,
            self::TRANSLATION_METHOD_SITE_GROUP,
            self::TRANSLATION_METHOD_LANGUAGE,
            self::TRANSLATION_METHOD_CUSTOM,
        ];
    }

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('sprout-fields', 'Address (Sprout Fields)');
    }

    /**
     * @inheritdoc
     */
    public static function hasContentColumn(): bool
    {
        return false;
    }

    /**
     * @return string|null
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws SiteNotFoundException
     */
    public function getSettingsHtml()
    {
        return SproutBaseFields::$app->addressField->getSettingsHtml($this);
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
        return SproutBaseFields::$app->addressField->getInputHtml($this, $value, $element);
    }

    /**
     * How the field output will appear for Revisions
     *
     * @param                  $value
     * @param ElementInterface $element
     *
     * @return string
     */
    public function getStaticHtml($value, ElementInterface $element): string
    {
        return SproutBaseFields::$app->addressField->getStaticHtml($this, $value, $element);
    }

    /**
     * @param                       $value
     * @param ElementInterface|null $element
     *
     * @return AddressModel|mixed|null
     */
    public function normalizeValue($value, ElementInterface $element = null)
    {
        return SproutBaseFields::$app->addressField->normalizeValue($this, $value, $element);
    }

    /**
     * @param ElementInterface $element
     * @param bool             $isNew
     *
     * @throws Throwable
     * @throws Exception
     * @throws StaleObjectException
     */
    public function afterElementSave(ElementInterface $element, bool $isNew)
    {
        SproutBaseFields::$app->addressField->afterElementSave($this, $element, $isNew);
        parent::afterElementSave($element, $isNew);
    }

    /**
     * @inheritdoc
     */
    public function getTableAttributeHtml($value, ElementInterface $element): string
    {

        if (!$value) {
            return '';
        }

        $addressFormatRepository = new AddressFormatRepository();
        $countryRepository = new CountryRepository();
        $subdivisionRepository = new SubdivisionRepository();
        $formatter = new DefaultFormatter($addressFormatRepository, $countryRepository, $subdivisionRepository);

        $address = new CommerceGuysAddress();
        $address = $address
            ->withCountryCode($value->countryCode)
            ->withAdministrativeArea($value->administrativeAreaCode)
            ->withLocality($value->locality)
            ->withPostalCode($value->postalCode)
            ->withAddressLine1($value->address1)
            ->withAddressLine2($value->address2);

        $html = $formatter->format($address);

        $html = str_replace(' ', '&nbsp;', $html);

        return $html;
    }
}
