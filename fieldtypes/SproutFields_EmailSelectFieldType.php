<?php
namespace Craft;

/**
 * Class SproutFields_EmailSelectFieldType
 *
 * @package Craft
 */
class SproutFields_EmailSelectFieldType extends BaseOptionsFieldType
{
	/**
	 * @return string
	 */
	public function getName()
	{
		return Craft::t('Email Select');
	}

	/**
	 * @return mixed
	 */
	public function defineContentAttribute()
	{
		return array(AttributeType::Mixed);
	}

	/**
	 * @param string $name
	 * @param mixed  $value
	 *
	 * @return string
	 */
	public function getInputHtml($name, $value)
	{
		$options = $this->model->settings['maskedOptions'];

		// If this is a new entry, look for a default option
		if ($this->isFresh())
		{
			$value = $this->getDefaultValue();
		}
		return craft()->templates->render('sproutfields/_fieldtypes/emailselect/input', array(
			'name'    => $name,
			'value'   => $value,
			'options' => $options
		)
		);
	}

	/**
	 * @return string
	 */
	public function getSettingsHtml()
	{
		$options = $this->getOptions();

		if (!$options)
		{
			$options = array(array('label' => '', 'value' => ''));
		}

		return craft()->templates->renderMacro(
			'_includes/forms', 'editableTableField', array(
			array(
				'label'        => $this->getOptionsSettingsLabel(),
				'instructions' => Craft::t('Define the available options.'),
				'id'           => 'options',
				'name'         => 'options',
				'addRowLabel'  => Craft::t('Add an option'),
				'cols'         => array(
					'label'   => array(
						'heading'      => Craft::t('Name'),
						'type'         => 'singleline',
						'autopopulate' => 'value'
					),
					'value'   => array(
						'heading' => Craft::t('Email'),
						'type'    => 'singleline',
						'class'   => 'code'
					),
					'default' => array(
						'heading' => Craft::t('Default?'),
						'type'    => 'checkbox',
						'class'   => 'thin'
					),
				),
				'rows'         => $options
			)
		)
		);
	}

	/**
	 * @param mixed $value
	 *
	 * @return bool|string
	 */
	public function validate($value)
	{
		if (!filter_var($value, FILTER_VALIDATE_EMAIL))
		{
			return "Email does not validate";
		}

		return true;
	}

	/**
	 * Creates a copy of model.settings.options with all values replaced with indices in model.settings.maskedOptions
	 *
	 * @see prepValueFromPost()
	 *
	 * @param mixed $value
	 *
	 * @return mixed
	 */
	public function prepValue($value)
	{
		$settings = array();

		foreach ($this->model->settings['options'] as $index => $option)
		{
			// Replaces the value in a given option with its index inside settings
			$option['value'] = $index;

			// Adds the updated/masked option to the masked options list
			$settings['maskedOptions'][$index] = $option;
		}

		// Combines default options and masked options inside settings for later retrieval
		$this->model->setAttribute('settings', array_merge($this->model->settings, $settings));

		unset($settings);

		return $option['value'];
	}

	/**
	 * Returns the value inside the model.settings.options identified by the index submitted in $value
	 *
	 * @see prepValue()
	 *
	 * @param int $value The email address index due to masking on form rendering
	 *
	 * @throws Exception
	 * @return mixed
	 */
	public function prepValueFromPost($value)
	{
		if (!array_key_exists($value, $this->model->settings['options']))
		{
			throw new Exception(Craft::t('Email selection not allowed'));
		}

		return $this->model->settings['options'][$value]['value'];
	}

	/**
	 * @return string
	 */
	protected function getOptionsSettingsLabel()
	{
		return Craft::t('Dropdown Options');
	}
}





