<?php

namespace barrelstrength\sproutfields\fields;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\base\PreviewableFieldInterface;
use yii\db\Schema;

use barrelstrength\sproutfields\SproutFields;
use barrelstrength\sproutcore\SproutCore;
use barrelstrength\sproutcore\web\sproutfields\emailfield\EmailFieldAsset;

class Email extends Field implements PreviewableFieldInterface
{
	/**
	 * @var string|null
	 */
	public $customPattern;

	/**
	 * @var bool
	 */
	public $customPatternToggle;

	/**
	 * @var string|null
	 */
	public $customPatternErrorMessage;

	/**
	 * @var bool
	 */
	public $uniqueEmail;

	/**
	 * @var string|null
	 */
	public $placeholder;

	public static function displayName(): string
	{
		return SproutFields::t('Email Address');
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
		return Craft::$app->getView()->renderTemplate('sproutfields/_fieldtypes/email/settings',
			[
				'field' => $this,
			]);
	}

	/**
	 * @inheritdoc
	 */
	public function getInputHtml($value, ElementInterface $element = null): string
	{
		$view = Craft::$app->getView();
		$view->registerAssetBundle(EmailFieldAsset::class);

		$name = $this->handle;
		$inputId          = Craft::$app->getView()->formatInputId($name);
		$namespaceInputId = Craft::$app->getView()->namespaceInputId($inputId);

		$fieldContext = SproutFields::$app->utilities->getFieldContext($this, $element);

		// Set this to false for Quick Entry Dashboard Widget
		$elementId = ($element != null) ? $element->id : false;

		return Craft::$app->getView()->renderTemplate('sprout-core/sproutfields/fields/email/input',
			[
				'id'           => $namespaceInputId,
				'name'         => $name,
				'value'        => $value,
				'elementId'    => $elementId,
				'fieldContext' => $fieldContext,
				'placeholder'  => $this->placeholder
			]);
	}

	/**
	 * @inheritdoc
	 */
	public function getElementValidationRules(): array
	{
		$rules = parent::getElementValidationRules();
		$rules[] = 'validateEmail';

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
	public function validateEmail(ElementInterface $element)
	{
		$value = $element->getFieldValue($this->handle);

		$customPattern = $this->customPattern;
		$checkPattern  = $this->customPatternToggle;

		if (!SproutCore::$app->email->validateEmailAddress($value, $customPattern, $checkPattern))
		{
			$element->addError($this->handle,
				SproutCore::$app->email->getErrorMessage(
					$this->name, $this)
			);
		}

		$uniqueEmail = $this->uniqueEmail;

		if ($uniqueEmail && !SproutCore::$app->email->validateUniqueEmailAddress($value, $element, $this))
		{
			$element->addError($this->handle,
				SproutFields::t($this->name . ' must be a unique email.')
			);
		}
	}
}
