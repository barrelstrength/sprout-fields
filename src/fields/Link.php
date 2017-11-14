<?php

namespace barrelstrength\sproutfields\fields;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\base\PreviewableFieldInterface;
use yii\db\Schema;

use barrelstrength\sproutfields\SproutFields;
use barrelstrength\sproutbase\SproutBase;

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
			'sprout-fields/_fieldtypes/link/settings',
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
		$name = $this->handle;
		$inputId = Craft::$app->getView()->formatInputId($name);
		$namespaceInputId = Craft::$app->getView()->namespaceInputId($inputId);

		$fieldContext = SproutBase::$app->utilities->getFieldContext($this, $element);

		return Craft::$app->getView()->renderTemplate('sprout-base/sproutfields/_includes/forms/link/input', [
				'namespaceInputId' => $namespaceInputId,
				'id' => $inputId,
				'name' => $name,
				'value' => $value,
				'fieldContext' => $fieldContext,
				'placeholder' => $this->placeholder
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

		$handle = $this->handle;
		$name = $this->name;

		if (!SproutBase::$app->link->validate($value, $this))
		{
			$element->addError(
				$this->handle,
				SproutBase::$app->link->getErrorMessage($this)
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
			$html = '<a href="'.$value.'" target="_blank">'.$value.'</a>';
		}

		return $html;
	}
}
