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
		$namespaceInputName = craft()->templates->namespaceInputName($inputId);

		$addressField = new SproutFields_AddressModel;
		//$addressField = $value;

		// Convert to array to pass to JS
		$elementId = null;
		$fieldId   = null;

		$addressFieldArray = array('elementId' => $elementId, 'fieldId' => $fieldId);

		$output = "<div class='fieldgroup-box sproutaddressfield-box container-$namespaceInputId'>";
		$countryCode = (($addressField->countryCode != null) ?  $addressField->countryCode : 'US');

		craft()->sproutFields_addressFormField->setParams($countryCode, $name, $addressField, $namespaceInputId);
		$output.= craft()->sproutFields_addressFormField->countryInput();
		$output.="<div class='format-box'>";
		$form = craft()->sproutFields_addressFormField->setForm();
		$output .= $form;
		$output.="</div>";

		$output.= "</div>";
		craft()->templates->includeCssResource('sproutfields/css/sproutaddressfields.css');

		// Pass cp url to call ajax url
		craft()->templates->includeJs("var cpTrigger = '" . craft()->config->get('cpTrigger') . "'");
		craft()->templates->includeJs("var sproutAddressId = '" . $namespaceInputId . "'");
		craft()->templates->includeJs("var sproutAddressNamespaceInputName = 'fields[$name]'");
		craft()->templates->includeJs("var sproutAddressInputId = '" . $inputId . "'");
		craft()->templates->includeJs("var sproutAddress = " . json_encode($addressFieldArray, JSON_PRETTY_PRINT));
		craft()->templates->includeJs("var sproutAddressName = '" . $name . "'");
		craft()->templates->includeJsResource('sproutfields/js/sproutaddressfields.js');
		$rendered = $output;
		$this->endRendering();

		return TemplateHelper::getRaw($rendered);
	}

	public function getType()
	{
		return 'SproutFields_Address';
	}
}