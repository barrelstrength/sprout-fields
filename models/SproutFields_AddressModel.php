<?php
namespace Craft;

class SproutFields_AddressModel extends BaseModel
{
	protected function defineAttributes()
	{
		return array(
			'id' 				 => array(AttributeType::Number),
			'elementId'     	 => array(AttributeType::Number),
			'fieldId'       	 => array(AttributeType::Number),
			'countryCode' 		 => array(AttributeType::String),
			'administrativeArea' => array(AttributeType::String),
			'locality'           => array(AttributeType::String),
			'dependentLocality'  => array(AttributeType::String),
			'postalCode'    	 => array(AttributeType::String),
			'sortingCode'    	 => array(AttributeType::String),
			'address1'      	 => array(AttributeType::String),
			'address2'      	 => array(AttributeType::String),

		);
	}

	public function displayAddressFormat()
	{
		$params = array('elementId' => $this->elementId, 'fieldId' => $this->fieldId);
		$model = craft()->sproutFields_addressField->getAddress($params);
		$address = craft()->sproutFields_addressFormField->displayAddress($model);
		return TemplateHelper::getRaw($address);
	}
}
