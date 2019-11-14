<?php

namespace barrelstrength\sproutfields\fields;

use barrelstrength\sproutbasefields\base\AddressFieldTrait;
use CommerceGuys\Addressing\AddressFormat\AddressFormatRepository;
use CommerceGuys\Addressing\Formatter\DefaultFormatter;
use CommerceGuys\Addressing\Address as CommerceGuysAddress;
use CommerceGuys\Addressing\Subdivision\SubdivisionRepository;
use CommerceGuys\Addressing\Country\CountryRepository;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\base\PreviewableFieldInterface;
use craft\gql\GqlEntityRegistry;
use craft\gql\TypeLoader;
use Craft;
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
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('sprout-fields', 'Address (Sprout Fields)');
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

    /**
     * @inheritdoc
     * @since 3.3.0
     */
    public function getContentGqlType()
    {
        $typeName = $this->handle.'_SproutAddressField';

        $addressType = GqlEntityRegistry::getEntity($typeName)
            ?: GqlEntityRegistry::createEntity($typeName, new ObjectType([
                'name'   => $typeName,
                'fields' => [
                    'countryCode' => Type::string(),
                    'administrativeAreaCode' => Type::string(),
                    'locality' => Type::string(),
                    'postalCode' => Type::string(),
                    'address1' => Type::string(),
                    'address2' => Type::string(),
                ],
            ]));

        TypeLoader::registerType($typeName, static function () use ($addressType) { return $addressType ;});

        return $addressType;
    }

}
