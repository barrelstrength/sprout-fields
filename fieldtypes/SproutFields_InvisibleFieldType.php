<?php
namespace Craft;

class SproutFields_InvisibleFieldType extends BaseFieldType implements IPreviewableFieldType
{
	/**
	 * @return string
	 */
	public function getName()
	{
		return Craft::t('Invisible');
	}

	/**
	 * Define settings
	 *
	 * @return array
	 */
	protected function defineSettings()
	{
		return array(
			'allowEdits' => array(AttributeType::Bool),
			'hideValue'  => array(AttributeType::Bool),
			'value'      => array(AttributeType::String),
		);
	}

	/**
	 * Display our settings
	 *
	 * @return string Returns the template which displays our settings
	 */
	public function getSettingsHtml()
	{
		$settings = $this->getSettings();

		return craft()->templates->render(
			'sproutfields/_fieldtypes/invisible/settings',
			array(
				'settings' => $settings
			)
		);
	}

	/**
	 * @param string $name
	 *
	 * @return string Return our fields input template
	 */
	public function getInputHtml($name, $value)
	{
		$inputId          = craft()->templates->formatInputId($name);
		$namespaceInputId = craft()->templates->namespaceInputId($inputId);

		return craft()->templates->render(
			'sproutfields/_fieldtypes/invisible/input',
			array(
				'id'       => $namespaceInputId,
				'name'     => $name,
				'value'    => $value,
				'settings' => $this->getSettings()
			)
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
		$value = craft()->httpSession->get($this->model->handle, $value);

		craft()->httpSession->remove($this->model->handle);

		return $value;
	}

	/**
	 * @param mixed $value
	 *
	 * @return mixed|string
	 */
	public function getTableAttributeHtml($value)
	{
		$hiddenValue = "";
		$settings    = $this->getSettings();

		if ($value != "")
		{
			$hiddenValue = $settings->hideValue ? "&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" : $value;
		}

		return $hiddenValue;
	}
}
