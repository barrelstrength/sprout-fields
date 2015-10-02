<?php
namespace Craft;

class SproutFields_HiddenFieldType extends BaseFieldType
{
	/**
	 * @return string
	 */
	public function getName()
	{
		return Craft::t('Hidden');
	}

	/**
	 * @return string
	 */
	public function getInputHtml($name, $value)
	{
		$vars = array(
			'id'    => $name,
			'name'  => $name,
			'value' => $value,
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

	/**
	 * @return array
	 */
	public function defineSettings()
	{
		return array(
			'value' => AttributeType::String,
		);
	}
}
