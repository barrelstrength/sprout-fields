<?php

namespace barrelstrength\sproutfields\fields;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\base\PreviewableFieldInterface;
use craft\helpers\Db;
use yii\db\Schema;

use barrelstrength\sproutfields\SproutFields;
use barrelstrength\sproutcore\web\sproutfields\phonefield\PhoneFieldAsset;

class Phone extends Field implements PreviewableFieldInterface
{
	/**
	 * @var string|null
	 */
	public $customPatternErrorMessage;

	/**
	 * @var bool|null
	 */
	public $customPatternToggle;

	/**
	 * @var bool|null
	 */
	public $inputMask;

	/**
	 * @var string|null
	 */
	public $mask;

	/**
	 * @var string|null
	 */
	public $placeholder;

	public static function displayName(): string
	{
		return SproutFields::t('Phone Number');
	}

	/**
	 * @inheritdoc
	 */
	public function getContentColumnType(): string
	{
		return Schema::TYPE_STRING;
	}

	/**
	 * @inheritdoc
	 */
	public function getSettingsHtml()
	{
		return Craft::$app->getView()->renderTemplate(
			'sproutfields/_fieldtypes/phone/settings',
			[
				'field' => $this,
			]
		);
	}

	/**
	 * @inheritdoc
	 */
	public function getInputHtml($value, ElementInterface $element = null): string
	{
		$view = Craft::$app->getView();
		$view->registerAssetBundle(PhoneFieldAsset::class);
		$name = $this->handle;
		$inputId          = Craft::$app->getView()->formatInputId($name);
		$namespaceInputId = Craft::$app->getView()->namespaceInputId($inputId);

		return Craft::$app->getView()->renderTemplate(
			'sprout-core/sproutfields/fields/phone/input',
			[
				'id'    => $namespaceInputId,
				'name'  => $this->handle,
				'value' => $value,
				'field' => $this
			]
		);
	}

	/**
	 * @inheritdoc
	 */
	public function getElementValidationRules(): array
	{
		$rules = parent::getElementValidationRules();
		$rules[] = 'validatePhone';

		return $rules;
	}

	/**
	 * Validates our fields submitted value beyond the checks
	 * that were assumed based on the content attribute.
	 *
	 *
	 * @param ElementInterface $element
	 *
	 * @return void
	 */
	public function validatePhone(ElementInterface $element)
	{
		$value = $element->getFieldValue($this->handle);

		$handle  = $this->handle;
		$name    = $this->name;

		if ($this->mask == "")
		{
			$this->mask = SproutFields::$api->phone->getDefaultMask();
		}

		if (!SproutFields::$api->phone->validate($value, $this->mask))
		{
			$element->addError(
				$this->handle,
				SproutFields::$api->phone->getErrorMessage($this)
			);
		}
	}

	/**
	 * @inheritdoc
	 */
	public function getTableAttributeHtml($value, ElementInterface $element): string
	{
		$html = '';

		if ($value)
		{
			$formatter = Craft::$app->getFormatter();

			$html = '<a href="tel:' . $value . '" target="_blank">' . $value . '</a>';
		}

		return $html;
	}
}
