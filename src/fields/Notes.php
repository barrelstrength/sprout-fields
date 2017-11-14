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
			'sprout-fields/_fieldtypes/notes/settings',
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
			'sprout-base/sproutfields/_includes/forms/notes/input',
			[
				'id'               => $namespaceInputId,
				'name'             => $name,
				'field'            => $this,
				'selectedStyleCss' => $selectedStyleCss
			]
		);
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
