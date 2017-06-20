<?php

namespace barrelstrength\sproutfields\fields;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\base\PreviewableFieldInterface;
use yii\db\Schema;

use barrelstrength\sproutfields\SproutFields;
use barrelstrength\sproutcore\web\sproutfields\linkfield\LinkFieldAsset;

class Link extends Field implements PreviewableFieldInterface
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
	 * @var string|null
	 */
	public $customPattern;

	/**
	 * @var string|null
	 */
	public $placeholder;

	public static function displayName(): string
	{
		return SproutFields::t('Link');
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
			'sproutfields/_fieldtypes/link/settings',
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
		$view->registerAssetBundle(LinkFieldAsset::class);

		$name             = $this->handle;
		$inputId          = Craft::$app->getView()->formatInputId($name);
		$namespaceInputId = Craft::$app->getView()->namespaceInputId($inputId);

		$fieldContext = SproutFields::$api->utilities->getFieldContext($this, $element);

		return Craft::$app->getView()->renderTemplate(
			'sprout-core/sproutfields/fields/link/input',
			[
				'id'           => $namespaceInputId,
				'name'         => $name,
				'value'        => $value,
				'fieldContext' => $fieldContext,
				'placeholder'  => $this->placeholder
			]
		);
	}

	/**
	 * @inheritdoc
	 */
	public function getElementValidationRules(): array
	{
		$rules = parent::getElementValidationRules();
		$rules[] = 'validateLink';

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
	public function validateLink(ElementInterface $element)
	{
		$value = $element->getFieldValue($this->handle);

		$handle  = $this->handle;
		$name    = $this->name;

		if (!SproutFields::$api->link->validate($value, $this))
		{
			$element->addError(
				$this->handle,
				SproutFields::$api->link->getErrorMessage($this)
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
			$html = '<a href="' . $value . '" target="_blank">' . $value . '</a>';
		}

		return $html;
	}
}
