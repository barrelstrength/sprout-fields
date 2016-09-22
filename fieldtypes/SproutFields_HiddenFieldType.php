<?php
namespace Craft;

class SproutFields_HiddenFieldType extends BaseFieldType implements IPreviewableFieldType
{
	/**
	 * @return string
	 */
	public function getName()
	{
		return Craft::t('Hidden');
	}

	/**
	 * @return array
	 */
	public function defineSettings()
	{
		return array(
			'allowEdits' => array(AttributeType::Bool),
			'value'      => array(AttributeType::String),
		);
	}

	/**
	 * @return string
	 */
	public function getInputHtml($name, $value)
	{
		$vars = array(
			'id'       => $name,
			'name'     => $name,
			'value'    => $value,
			'settings' => $this->getSettings()
		);

		return craft()->templates->render('sproutfields/_fieldtypes/hidden/input', $vars);
	}

	/**
	 * @return string
	 */
	public function getSettingsHtml()
	{
		$vars = array(
			'settings' => $this->getSettings(),
		);

		return craft()->templates->render('sproutfields/_fieldtypes/hidden/settings', $vars);
	}
}
