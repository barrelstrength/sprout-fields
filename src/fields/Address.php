<?php

namespace barrelstrength\sproutfields\fields;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\base\PreviewableFieldInterface;
use yii\db\Schema;

use barrelstrength\sproutfields\SproutFields;
use barrelstrength\sproutbase\SproutBase;
use barrelstrength\sproutbase\helpers\AddressHelper;
use barrelstrength\sproutbase\models\sproutfields\Address as AddressModel;

class Address extends Field implements PreviewableFieldInterface
{
    /**
     * @var AddressHelper $addressHelper
     */
    protected $addressHelper;

    /**
     * @var string
     */
    public $country;

    /**
     * @var bool
     */
    public $countryToggle;

    /**
     * @var string|null
     */
    public $value;

    public function init()
    {
        $this->addressHelper = new AddressHelper();

        parent::init();
    }

    public static function displayName(): string
    {
        return SproutFields::t('Address');
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

        return Craft::$app->getView()->renderTemplate(
            'sprout-fields/_fieldtypes/address/settings',
            [
                'settings' => $this,
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

        return Craft::$app->getView()->renderTemplate(
            'sprout-base/sproutfields/_includes/forms/address/input',
            [
                'namespaceInputId' => $namespaceInputId,
                'namespaceInputName' => $namespaceInputName,
                'field' => $this,
                'addressId' => $value->id ?? null,
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function normalizeValue($value, ElementInterface $element = null)
    {
        if (is_array($value)){
            $addressInfoId = SproutBase::$app->address->saveAddressByPost("fields.address");
            // bad address or empty address
            if (!$addressInfoId){
                return null;
            }

            if (is_int($addressInfoId)){
                $value = $addressInfoId;
            }
        }

        if (is_numeric($value)) {
            // Address Model
            $value = SproutBase::$app->address->getAddressById($value);
        }
        // Always return AddressModel
        return $value;
    }

    /**
     * SerializeValue renamed from Craft2 - prepValue
     *
     * @param mixed $value
     *
     * @return BaseModel|mixed
     */
    public function serializeValue($value, ElementInterface $element = null)
    {
        if (empty($value)) {
            return;
        }

        if (is_object($value) && get_class($value) == AddressModel::class) {
            $value = $value->id;
        }

        // on the resave element task $value is the id
        $addressId = $value;
        // Comes when the field is saved by post request
        if (isset($value['id']) && $value['id']) {
            $addressId = $value['id'];
        }

        // let's save just the Address Id in the content table
        return $addressId;
    }
}
