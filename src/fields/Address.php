<?php

namespace barrelstrength\sproutfields\fields;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\base\PreviewableFieldInterface;
use yii\db\Schema;

use barrelstrength\sproutfields\SproutFields;
use barrelstrength\sproutcore\SproutCore;
use barrelstrength\sproutcore\helpers\AddressHelper;
use barrelstrength\sproutcore\models\sproutfields\Address as AddressModel;

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
				'settings'  => $this,
				'countries' =>$countries
			]
		);
	}

	/**
	 * @inheritdoc
	 */
	public function getInputHtml($value, ElementInterface $element = null): string
	{
		$name               = $this->handle;
		$inputId            = Craft::$app->getView()->formatInputId($name);
		$namespaceInputName = Craft::$app->getView()->namespaceInputName($inputId);
		$namespaceInputId   = Craft::$app->getView()->namespaceInputId($inputId);

		return Craft::$app->getView()->renderTemplate(
			'sprout-core/sproutfields/fields/address/input',
			[
				'namespaceInputId'   => $namespaceInputId,
				'namespaceInputName' => $namespaceInputName,
				'field'              => $this,
				'addressId'          => $value,
			]
		);
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
		if (empty($value)) return;

		// on the resave element task $value is the id
		$addressId = $value;
		// Comes when the field is saved by post request
		if (isset($value['id']) && $value['id'])
		{
			$addressId = $value['id'];
		}

		// let's save just the Address Id in the content table
		return $addressId;
	}

	/**
	 * Save the address info to the sproutcore_address table
	 */
	public function afterElementSave(ElementInterface $element, bool $isNew)
	{
		$fieldHandle = $this->handle;
		$addressInfo = $element->{$fieldHandle};

		// Make sure we are actually submitting our field
		if (is_array($addressInfo))
		{
			$addressInfo['modelId'] = $this->id;
			$addressModel = new AddressModel($addressInfo);

			if ($addressModel->validate() == true && SproutCore::$app->address->saveAddress($addressModel))
			{
				$addressId = $addressModel->id;

				$addressInfo['id'] = $addressId;

				$element->{$fieldHandle} = $addressInfo;

				// Update the field again with addressId value
				Craft::$app->getContent()->saveContent($element);
			}

			if ($addressModel->id == null && isset($this->id))
			{
				SproutCore::$app->address->deleteAddressByModelId($this->id);

				$element->getContent()->{$fieldHandle} = null;

				Craft::$app->getContent()->saveContent($element);
			}
		}

		parent::afterElementSave($element, $isNew);
	}
}
