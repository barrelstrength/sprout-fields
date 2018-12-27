<?php

namespace barrelstrength\sproutfields\fields;

use barrelstrength\sproutbase\app\fields\base\AddressFieldTrait;
use CommerceGuys\Addressing\AddressFormat\AddressFormatRepository;
use CommerceGuys\Addressing\Formatter\DefaultFormatter;
use CommerceGuys\Addressing\Address as CommerceGuysAddress;
use CommerceGuys\Addressing\Subdivision\SubdivisionRepository;
use CommerceGuys\Addressing\Country\CountryRepository;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\base\PreviewableFieldInterface;
use barrelstrength\sproutfields\SproutFields;
use yii\db\Schema;

/**
 * Class Address
 *
 * @package barrelstrength\sproutfields\fields
 *
 * @property string $contentColumnType
 */
class Address extends Field implements PreviewableFieldInterface
{
    use AddressFieldTrait;

    /**
     * @var string|null
     */
    public $value;

    /**
     * @var AddressHelper $addressHelper
     */
    public $addressHelper;

    public function init()
    {
        $this->addressHelper = new AddressHelper();

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return SproutFields::t('Address (Sprout Fields)');
    }

    /**
     * @inheritdoc
     */
    public function getContentColumnType(): string
    {
        return Schema::TYPE_INTEGER;
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
