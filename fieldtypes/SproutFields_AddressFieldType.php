<?php
namespace Craft;

class SproutFields_AddressFieldType extends BaseFieldType
{

	protected $defaultCountryCode = 'US';
	/**
	 * FieldType name
	 *
	 * @return string
	 */
	public function getName()
	{
		return Craft::t('Address');
	}

	/**
	 * Define database column
	 *
	 * @return false
	 */
	public function defineContentAttribute()
	{
		// We don't need a field in the Content table because
		// we are going to hijack the saving and retrieving of this
		// fieldtypes content so we can have multiple fields and store
		// them in a separate table.
		return false;
	}

	/**
	 * Display our FieldType
	 *
	 * @param string $name  Our FieldType handle
	 * @param string $value Always returns blank, our block
	 *                       only styles the Instructions field
	 * @return string Return our blocks input template
	 */
	public function getInputHtml($name, $value)
	{
		$inputId = craft()->templates->formatInputId($name);
		$namespaceInputId = craft()->templates->namespaceInputId($inputId);
		$namespaceInputName = craft()->templates->namespaceInputName($inputId);

		$addressField = craft()->sproutFields_addressField->getAddress($this);
		//$addressField = $value;

		// Convert to array to pass to JS
		$elementId = $this->element->id;
		$fieldId   = $this->model->id;

		$addressFieldArray = array('elementId' => $elementId, 'fieldId' => $fieldId);

		$output = "<div class='fieldgroup-box sproutaddressfield-box container-$namespaceInputId'>";
		$countryCode = (($addressField->countryCode != null) ?  $addressField->countryCode : $this->defaultCountryCode);

		if($this->model->hasErrors() && craft()->request->getPost()['fields'][$name]['countryCode'])
		{
			$countryCode = craft()->request->getPost()['fields'][$name]['countryCode'];
		}
		craft()->sproutFields_addressFormField->setParams($countryCode, $name, $addressField, $namespaceInputName);
		$output.= craft()->sproutFields_addressFormField->countryInput();
		//$output.= $namespaceInputName;
		$output.="<div class='format-box'>";

		$form = craft()->sproutFields_addressFormField->setForm();
		$output .= $form;
		$output.="</div>";

		$output.= "</div>";
		craft()->templates->includeCssResource('sproutfields/css/sproutaddressfields.css');

		// Pass cp url to call ajax url
		//$output.= $this->returnJs("var cpTrigger = '" . craft()->config->get('cpTrigger') . "'");
		//$output.= $this->returnJs("var sproutAddressId = '" . $namespaceInputId . "'");
		//$output.= $this->returnJs("var sproutAddressInputId = '" . $inputId . "'");
		//$output.= $this->returnJs("var sproutAddress = " . $sproutAddress);
		//$output.= $this->returnJs("var sproutAddressName = '" . $name . "'");
		$sproutAddress = json_encode($addressFieldArray, JSON_PRETTY_PRINT);

		craft()->templates->includeJsResource('sproutfields/js/SproutAddressField.js');
		craft()->templates->includeJs("var sproutAddress = " . $sproutAddress);
		craft()->templates->includeJs("var sproutAddressNamespaceInputName = '" . $namespaceInputName . "'");
		craft()->templates->includeJs("
			  new Craft.SproutAddressField(sproutAddress, '$name', sproutAddressNamespaceInputName)
		");
		return $output;
	}

	public function returnJs($scripts)
	{
		$output = '<script type="text/javascript">';
		$output.= $scripts;
		$output.= '</script>';

		return $output;
	}


	/**
	 * Performs any additional actions after the element has been saved.
	 */
	public function onAfterElementSave()
	{
		// get any overrides for this entry
		$oldAddressField = craft()->sproutFields_addressField->getAddress($this);

		$elementId   = $this->element->id;
		$fieldId     = $this->model->id;
		$content     = $this->element->getContent();
		$fieldHandle = $this->model->handle;

		$values      = $content->getAttribute($fieldHandle);

		// Make sure we are actually submitting our field
		if ( ! $values ) return;

		// @TODO
		// If a field is submitted and all the data is blank, should we
		// remove the corresponding address record?

		// Add the entry ID to the field data we will submit for One SEO
		$attributes['elementId'] = $elementId;
		$attributes['fieldId'] = $fieldId;

		// Grab all the other Address fields.
		$attributes = array_merge($attributes, $values);

		// If our address exists update it,
		// if not create it
		if ($oldAddressField->id)
		{
			$recordId = craft()->sproutFields_addressField->updateAddressField($oldAddressField->id, $attributes);
		}
		else
		{
			$recordId = craft()->sproutFields_addressField->createAddressField($attributes);
		}

		return $recordId;
	}

	public function validate($value)
	{

		if(craft()->sproutFields_addressFormField->validate($value) == "true")
		{
			return true;
		}
		else
		{

			$error = craft()->sproutFields_addressFormField->validate($value);
			$this->model->addError('sproutAddress', $error);
			return $error;
		}
	}

	/**
	 * Get model by field id
	 * @param mixed $value
	 * @return mixed
	 */
	public function prepValue($value)
	{

		$model = craft()->sproutFields_addressField->getAddress($this);
		return $model;
	}

}
