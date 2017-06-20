<?php

namespace barrelstrength\sproutfields\fields;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\base\PreviewableFieldInterface;
use yii\db\Schema;
use craft\web\assets\redactor\RedactorAsset;
use craft\web\assets\richtext\RichTextAsset;

use barrelstrength\sproutfields\SproutFields;

class Notes extends Field
{

	/**
	 * @var text
	 */
	public $instructions;

	/**
	 * @var text
	 */
	public $style;

	/**
	 * @var bool
	 */
	public $hideLabel;

	/**
	 * @var text
	 */
	public $output;

	public static function displayName(): string
	{
		return SproutFields::t('Notes');
	}

	/**
	 * Define database column
	 *
	 * @return false
	 */
	public function defineContentAttribute()
	{
		// field type doesn’t need its own column
		// in the content table, return false
		return false;
	}

	/**
	 * @inheritdoc
	 */
	public function getSettingsHtml()
	{
		$name             = $this->displayName();

		$inputId          = Craft::$app->getView()->formatInputId($name);
		$namespaceInputId = Craft::$app->getView()->namespaceInputId($inputId);

		$view = Craft::$app->getView();
		$view->registerAssetBundle(RedactorAsset::class);
		$view->registerAssetBundle(RichTextAsset::class);

		return Craft::$app->getView()->renderTemplate(
			'sproutfields/_fieldtypes/notes/settings',
			[
				'options'  => $this->getOptions(),
				'id'       => $namespaceInputId,
				'name'     => $name,
				'field'    => $this,
			]
		);
	}

	/**
	 * @inheritdoc
	 */
	public function getInputHtml($value, ElementInterface $element = null): string
	{
		$name             = $this->displayName();
		$inputId          = Craft::$app->getView()->formatInputId($name);
		$namespaceInputId = Craft::$app->getView()->namespaceInputId($inputId);
		$selectedStyle    = $this->style;
		$pluginSettings   = Craft::$app->plugins->
												getPlugin('sproutfields')->
												getSettings()->getAttributes();
		$selectedStyleCss = "";

		if (isset($pluginSettings[$selectedStyle]))
		{
			$selectedStyleCss = str_replace(
				"{{ name }}",
				$name,
				$pluginSettings[$selectedStyle]
			);
		}

		return Craft::$app->getView()->renderTemplate(
			'sprout-core/sproutfields/fields/notes/input',
			[
				'id'               => $namespaceInputId,
				'name'             => $name,
				'field'            => $this,
				'selectedStyleCss' => $selectedStyleCss
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

	private function getOptions()
	{
		$options = [
			'style'  => [
				'default'                    => 'Default',
				'infoPrimaryDocumentation'   => 'Primary Information',
				'infoSecondaryDocumentation' => 'Secondary Information',
				'warningDocumentation'       => 'Warning',
				'dangerDocumentation'        => 'Danger',
				'highlightDocumentation'     => 'Highlight'
			],
			'output' => [
				'markdown' => 'Markdown',
				'richText' => 'Rich Text',
				'html'     => 'HTML'
			]
		];

		return $options;
	}
}
