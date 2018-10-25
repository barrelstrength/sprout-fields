<?php

namespace barrelstrength\sproutfields\fields;


use barrelstrength\sproutbase\app\fields\base\AddressFieldTrait;
use CommerceGuys\Addressing\Formatter\DefaultFormatter;
use CommerceGuys\Addressing\Model\Address as CommerceGuysAddress;
use CommerceGuys\Addressing\Repository\AddressFormatRepository;
use CommerceGuys\Intl\Country\CountryRepository;
use CommerceGuys\Addressing\Repository\SubdivisionRepository;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\base\PreviewableFieldInterface;
use barrelstrength\sproutfields\SproutFields;
use barrelstrength\sproutbase\app\fields\helpers\AddressHelper;
use yii\db\Schema;

class Address extends Field implements PreviewableFieldInterface
{
    use AddressFieldTrait;
    /**
     * @var string
     */
    public $defaultCountry;

    /**
     * @var bool
     */
    public $hideCountryDropdown;

    /**
     * @var string|null
     */
    public $value;

    /**
     * @var AddressHelper $addressHelper
     */
    protected $addressHelper;

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
        if ($value['id'] === null)
        {
            return '';
        }

        $addressFormatRepository = new AddressFormatRepository();
        $countryRepository = new CountryRepository();
        $subdivisionRepository = new SubdivisionRepository();
        $formatter = new DefaultFormatter($addressFormatRepository, $countryRepository, $subdivisionRepository);

        $address = new CommerceGuysAddress();
        $address = $address
            ->setCountryCode($value->countryCode)
            ->setAdministrativeArea($value->administrativeArea)
            ->setLocality($value->locality)
            ->setPostalCode($value->postalCode)
            ->setAddressLine1($value->address1)
            ->setAddressLine2($value->address2);

        $html = $formatter->format($address);

        $html = str_replace(' ', '&nbsp;', $html);

        return $html;
    }
}
