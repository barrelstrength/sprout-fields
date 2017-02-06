<?php

namespace barrelstrength\sproutfields\fields;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\base\PreviewableFieldInterface;
use craft\helpers\Db;
use yii\db\Schema;

use barrelstrength\sproutfields\SproutFields;
use barrelstrength\sproutfields\assetbundles\emailfield\EmailFieldAsset;

class Invisible extends Field implements PreviewableFieldInterface
{
	/**
	 * @var basename(path)ool
	 */
	public $allowEdits;

	/**
	 * @var bool
	 */
	public $hideValue;

	/**
	 * @var string|null
	 */
	public $value;

	public static function displayName(): string
	{
		return Craft::t('sproutFields', 'Invisible');
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
			'sproutfields/_fieldtypes/invisible/settings',
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
		$name             = $this->handle;
		$inputId          = Craft::$app->getView()->formatInputId($name);
		$namespaceInputId = Craft::$app->getView()->namespaceInputId($inputId);

		return Craft::$app->getView()->renderTemplate(
			'sproutfields/_fieldtypes/invisible/input',
			[
				'id'           => $namespaceInputId,
				'name'         => $name,
				'value'        => $value,
				'field'     => $this
			]
		);
	}

	/**
	 * The value from post should be empty, we must attempt to grab the value from session
	 *
	 * @param mixed $value
	 *
	 * @return mixed
	 */
	public function prepValueFromPost($value)
	{
		// @todo how test if works on Craft 3?
		$value = Craft::$app->getSession()->get($this->handle, $value);

		Craft::$app->getSession()->remove($this->handle);

		return $value;
	}

	/**
	 * @inheritdoc
	 */
	public function getTableAttributeHtml($value, ElementInterface $element)
	{
		$hiddenValue = "";

		if ($value != "")
		{
			$hiddenValue = $this->hideValue ? "&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" : $value;
		}

		return $hiddenValue;
	}
}
