<?php
namespace Craft;

/**
 * Class SproutFields_NotesFieldType
 *
 * @package Craft
 */
class SproutFields_NotesFieldType extends BaseFieldType
{
	private $options = array(
		'style'  => array(
			'default'                    => 'Default',
			'infoPrimaryDocumentation'   => 'Primary Information',
			'infoSecondaryDocumentation' => 'Secondary Information',
			'warningDocumentation'       => 'Warning',
			'dangerDocumentation'        => 'Danger',
			'highlightDocumentation'     => 'Highlight'
		),
		'output' => array(
			'markdown' => 'Markdown',
			'richText' => 'Rich Text',
			'html'     => 'HTML'
		)
	);

	/**
	 * @return string
	 */
	public function getName()
	{
		return Craft::t('Notes');
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
	 * @return array
	 */
	protected function defineSettings()
	{
		return array(
			'instructions' => array(AttributeType::Mixed),
			'style'        => array(AttributeType::Mixed, 'default' => 'default'),
			'hideLabel'    => array(AttributeType::Bool, 'default' => false),
			'output'       => array(AttributeType::Mixed, 'default' => 'markdown')
		);
	}

	/**
	 * @return string
	 */
	public function getSettingsHtml()
	{
		$settings         = $this->getSettings();
		$name             = $this->getName();
		$inputId          = craft()->templates->formatInputId($name);
		$namespaceInputId = craft()->templates->namespaceInputId($inputId);

		return craft()->templates->render(
			'sproutfields/_fieldtypes/notes/settings', array(
				'options'  => $this->options,
				'settings' => $settings,
				'id'       => $namespaceInputId,
				'name'     => $name
			)
		);
	}

	/**
	 * @param string $name   Our blocktype handle
	 * @param string $value  Always returns blank, our block
	 *                       only styles the Instructions field
	 *
	 * @return string Return our blocks input template
	 */
	public function getInputHtml($name, $value)
	{

		$inputId          = craft()->templates->formatInputId($name);
		$namespaceInputId = craft()->templates->namespaceInputId($inputId);

		$settings       = $this->getSettings();
		$selectedStyle  = $settings->style;
		$pluginSettings = craft()->plugins->getPlugin('sproutfields')->getSettings()->getAttributes();

		// @todo - can probably simplify this code once settings are in place
		$selectedStyleCss = "";
		if (isset($pluginSettings[$selectedStyle]))
		{
			$selectedStyleCss = str_replace("{{ name }}", $name, $pluginSettings[$selectedStyle]);
		}

		return craft()->templates->render(
			'sproutfields/_fieldtypes/notes/input',
			array(
				'id'               => $namespaceInputId,
				'name'             => $name,
				'settings'         => $settings,
				'selectedStyleCss' => $selectedStyleCss
			)
		);
	}
}
