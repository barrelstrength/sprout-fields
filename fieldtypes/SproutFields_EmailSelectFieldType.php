<?php
namespace Craft;

/**
 * Class SproutFields_EmailSelectFieldType
 *
 * @package Craft
 */
class SproutFields_EmailSelectFieldType extends BaseOptionsFieldType implements IPreviewableFieldType
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
		$valueOptions = $value->getOptions();

		$anySelected = sproutFields()->isAnyOptionsSelected($valueOptions, $value->value);

		$value = $value->value;

		if ($anySelected === false)
		{
			$value = $this->getDefaultValue();
		}

		$options = $this->model->settings['options'];

		return craft()->templates->render('sproutfields/_fieldtypes/emailselect/input', array(
			'name'    => $name,
			'value'   => $value,
			'options' => $options
		));
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
		$emailAddresses = ArrayHelper::stringToArray($value);

		$emailAddresses = array_unique($emailAddresses);

		if (count($emailAddresses))
		{
			$invalidEmails = array();
			foreach ($emailAddresses as $emailAddress)
			{
				if (!filter_var($emailAddress, FILTER_VALIDATE_EMAIL))
				{
					$invalidEmails[] = Craft::t($emailAddress . " email does not validate");
				}
			}
		}

		if (!empty($invalidEmails)) return $invalidEmails;

		return true;
	}

	/**
	 * @return string
	 */
	protected function getOptionsSettingsLabel()
	{
		return Craft::t('Dropdown Options');
	}

	/**
	 * @param mixed $value
	 *
	 * @return string
	 */
	public function getTableAttributeHtml($value)
	{
		$html = $value->label . ': <a href="mailto:' . $value . '" target="_blank">' . $value . '</a>';

		return $html;
	}
}





