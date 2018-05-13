<?php

namespace barrelstrength\sproutfields\fields;


use CommerceGuys\Addressing\Formatter\DefaultFormatter;
use CommerceGuys\Addressing\Model\Address as CommerceGuysAddress;
use CommerceGuys\Addressing\Repository\AddressFormatRepository;
use CommerceGuys\Addressing\Repository\CountryRepository;
use CommerceGuys\Addressing\Repository\SubdivisionRepository;
use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\base\PreviewableFieldInterface;

use barrelstrength\sproutfields\SproutFields;
use barrelstrength\sproutbase\SproutBase;
use barrelstrength\sproutbase\app\fields\helpers\AddressHelper;
use barrelstrength\sproutbase\app\fields\models\Address as AddressModel;
use yii\db\Schema;

class Address extends Field implements PreviewableFieldInterface
{
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

    public static function displayName(): string
    {
        return SproutFields::t('Address (Sprout)');
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
    public function getSettingsHtml()
    {
        $countries = $this->addressHelper->getCountries();
        $settings = $this->getSettings();

        if ($settings !== null && !isset($settings['defaultCountry']))
        {
            $settings['defaultCountry'] = 'US';
            $settings['country'] = 'US';
        }

        return Craft::$app->getView()->renderTemplate(
            'sprout-base-fields/_components/fields/formfields/address/settings',
            [
                'settings' => $settings,
                'countries' => $countries
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {
        $name = $this->handle;
        $inputId = Craft::$app->getView()->formatInputId($name);
        $namespaceInputName = Craft::$app->getView()->namespaceInputName($inputId);
        $namespaceInputId = Craft::$app->getView()->namespaceInputId($inputId);

        $settings = $this->getSettings();

        $defaultCountryCode = $settings['defaultCountry'] ?? null;
        $hideCountryDropdown = $settings['hideCountryDropdown'] ?? null;

        $addressId = null;

        if (is_object($value)) {
            $addressId = $value->id;
        } elseif (is_array($value)) {
            $addressId = $value['id'];
        }

        return Craft::$app->getView()->renderTemplate(
            'sprout-base-fields/_components/fields/formfields/address/input',
            [
                'namespaceInputId' => $namespaceInputId,
                'namespaceInputName' => $namespaceInputName,
                'field' => $this,
                'addressId' => $addressId,
                'defaultCountryCode' => $defaultCountryCode,
                'hideCountryDropdown' => $hideCountryDropdown
            ]
        );
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

    /**
     * Prepare our Address for use as an AddressModel
     *
     * @param mixed                 $value
     * @param ElementInterface|null $element
     *
     * @return AddressModel|mixed|null
     */
    public function normalizeValue($value, ElementInterface $element = null)
    {
        $addressModel = new AddressModel();

        // Numeric value when retrieved from db
        if (is_numeric($value)) {
            $addressModel = SproutBase::$app->addressField->getAddressById($value);
        }

        // Array value from post data
        if (is_array($value)) {
            $value['fieldId'] = $this->id ?? null;
            $addressModel = new AddressModel();
            $addressModel->setAttributes($value, false);
        }

        // return null when clearing address to save null value on content table
        if (!$addressModel->validate(null, false)) {
            return null;
        }

        return $addressModel;
    }

    /**
     *
     * Prepare the field value for the database.
     *
     * We store the Address ID in the content column.
     *
     * @param mixed                 $value
     * @param ElementInterface|null $element
     *
     * @return array|bool|mixed|null|string
     */
    public function serializeValue($value, ElementInterface $element = null)
    {
        if (empty($value)) {
            return false;
        }

        $addressId = null;

        // When loading a Field Layout with an Address Field
        if (is_object($value) && get_class($value) == AddressModel::class) {
            $addressId = $value->id;
        }

        // For the ResaveElements task $value is the id
        if (is_int($value)) {
            $addressId = $value;
        }

        // When the field is saved by post request the id an attribute on $value
        if (isset($value['id']) && $value['id']) {
            $addressId = $value['id'];
        }

        // Save the addressId in the content table
        return $addressId;
    }

    /**
     * Save our Address Field a first time and assign the Address Record ID back to the Address field model
     * We'll save our Address Field a second time in afterElementSave to capture the Element ID for new entries.
     *
     * @param ElementInterface $element
     * @param bool             $isNew
     *
     * @return bool
     * @throws \Exception
     * @throws \yii\db\Exception
     */
    public function beforeElementSave(ElementInterface $element, bool $isNew) : bool
    {
        $address = $element->getFieldValue($this->handle);

        if ($address instanceof AddressModel)
        {
            $address->elementId = $element->id;
            $address->siteId = $element->siteId;
            $address->fieldId = $this->id;

            SproutBase::$app->addressField->saveAddress($address);
        }


        return true;

    }

    /**
     * Save our Address Field a second time for New Entries to ensure we have the Element ID.
     *
     * @param ElementInterface $element
     * @param bool             $isNew
     *
     * @return bool|void
     * @throws \Exception
     * @throws \yii\db\Exception
     */
    public function afterElementSave(ElementInterface $element, bool $isNew)
    {
        if ($isNew)
        {
            $address = $element->getFieldValue($this->handle);

            if ($address instanceof AddressModel)
            {
                $address->elementId = $element->id;
                SproutBase::$app->addressField->saveAddress($address);
            }
        }
    }
}
