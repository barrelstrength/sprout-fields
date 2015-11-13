<?php

namespace Craft;


class SproutFieldsAddressField extends SproutFieldsBaseField
{

	/**
	 * @return string
	 */
	public function getType()
	{
		return 'SproutFields_Address';
	}

	public function getInputHtml($field, $value, $settings, array $renderingOptions = null)
	{

		$this->beginRendering();
		$name = $field->handle;

		$namespaceInputName ="fields[$name]";

		$addressField = new SproutFields_AddressModel;


		// Convert to array to pass to JS
		$elementId = null;
		$fieldId   = null;

		$addressFieldArray = array('elementId' => $elementId, 'fieldId' => $fieldId);
		$sproutAddress = json_encode($addressFieldArray, JSON_PRETTY_PRINT);

		$output = "<div class='fieldgroup-box sproutaddressfield-box container-$name'>";
		$countryCode = (($addressField->countryCode != null) ?  $addressField->countryCode : 'US');

		if(!empty($_POST))
		{
			$fieldPost = craft()->request->getPost();

			$countryCode = $fieldPost['fields'][$name]['countryCode'];
			$fields = $fieldPost['fields'][$name];
			if(is_array(craft()->sproutFields_addressFormField->validate($fields)))
			{
				$addressField = SproutFields_AddressModel::populateModel($fields);
			}

		}

		craft()->sproutFields_addressFormField->setParams($countryCode, $name, $sproutAddress, $addressField, $namespaceInputName);
		$output.= craft()->sproutFields_addressFormField->countryInput();
		$output.="<div class='format-box'>";
		$form = craft()->sproutFields_addressFormField->setForm();
		$output .= $form;
		$output.="</div>";

		$output.= "</div>";
		craft()->templates->includeCssResource('sproutfields/css/sproutaddressfields.css');

		// Front end ajax

		craft()->templates->includeJsResource('sproutfields/js/sproutaddressfields.js');
		$rendered = $output;
		$this->endRendering();

		return TemplateHelper::getRaw($rendered);
	}

}