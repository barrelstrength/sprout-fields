<?php

namespace Craft;


class SproutFields_Address extends SproutFieldsSproutFormsBaseField
{
	public function getInputHtml($field, $value, $settings, array $renderingOptions = null)
	{

		$this->beginRendering();
		$name = $field->handle;

		$inputId = craft()->templates->formatInputId($name);
		$namespaceInputId = craft()->templates->namespaceInputId($inputId);

		$addressField = craft()->sproutFields_addressField->getAddress($this);
		//$addressField = $value;

		// Convert to array to pass to JS
		$elementId = $this->element->id;
		$fieldId   = $this->model->id;

		$addressFieldArray = array('elementId' => $elementId, 'fieldId' => $fieldId);

		$output = "<div class='fieldgroup-box sproutaddressfield-box'>";
		$countryCode = (($addressField->countryCode != null) ?  $addressField->countryCode : $this->defaultCountryCode);




		if($this->model->hasErrors() && craft()->request->getPost()['fields'][$name]['countryCode'])
		{
			$countryCode = craft()->request->getPost()['fields'][$name]['countryCode'];
		}
		craft()->sproutFields_addressFormField->setParams($countryCode, $name, $addressField);
		$output.= craft()->sproutFields_addressFormField->countryInput();
		$output.="<div class='format-box'>";
		$form = craft()->sproutFields_addressFormField->setForm();
		$output .= $form;
		$output.="</div>";

		$output.= "</div>";
		craft()->templates->includeCssResource('sproutfields/css/sproutaddressfields.css');

		// Pass cp url to call ajax url
		craft()->templates->includeJs("var cpTrigger = '" . craft()->config->get('cpTrigger') . "'");
		craft()->templates->includeJs("var sproutAddress = " . json_encode($addressFieldArray, JSON_PRETTY_PRINT));
		craft()->templates->includeJs("var sproutAddressName = '" . $name . "'");
		craft()->templates->includeJsResource('sproutfields/js/sproutaddressfields.js');
		$rendered = $ouput;
		$this->endRendering();

		return TemplateHelper::getRaw($rendered);
	}

	public function getType()
	{
		return 'SproutFields_Address';
	}
}