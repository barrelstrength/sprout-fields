<?php

namespace Craft;

class SproutFields_AddressFieldService extends BaseApplicationComponent
{
	protected $addressRecord;
	public $sproutAddressForm;

	public function __construct($addressRecord = null)
	{
		$this->addressRecord = $addressRecord;
		if (is_null($this->addressRecord)) {
			$this->addressRecord = SproutFields_AddressRecord::model();
		}
	}

	public function init()
	{
		parent::init();

		$this->sproutAddressForm = Craft::app()->getComponent('sproutAddress_Form');

	}

	/**
	 * Get a new blank item
	 *
	 * @param  array               $attributes
	 * @return OneSeo_SeoDataModel
	 */
	public function newModel($attributes = array())
	{
		$model = new SproutFields_AddressModel();
		$model->setAttributes($attributes);

		return $model;
	}

	/**
	 * Get all Fallbacks from the database.
	 *
	 * @return array
	 */
	public function getAllAddresses()
	{
		$records = $this->addressRecord->findAll(array('order'=>'state'));

		return SproutFields_AddressModel::populateModels($records, 'id');
	}

	/**
	 * Get a specific Fallbacks from the database based on ID. If no Fallbacks exists, null is returned.
	 *
	 * @param  int   $id
	 * @return mixed
	 */
	public function getAddressById($id)
	{
		if ($record = $this->addressRecord->findByPk($id)) 
		{
			return SproutFields_AddressModel::populateModel($record);
		}
		else
		{
			return new SproutFields_AddressModel();
		}
	}

	public function getAddress($field)
	{
		if(is_array($field))
		{
			$elementId = $field['elementId'];
			$fieldId = $field['fieldId'];
		}
		else
		{
			$elementId = $field->element->id;
			$fieldId   = $field->model->id;
		}


		$query = craft()->db->createCommand()
			->select('*')
			->from('SproutFields_address')
			->where(
				array(
					'AND',
					'elementId = :elementId',
					'fieldId = :fieldId'
				),
				array(
					':elementId' => $elementId,
					':fieldId' => $fieldId
				))
			->queryRow();

		return SproutFields_AddressModel::populateModel($query);
	}

	public function createAddressField($attributes)
	{
		craft()->db->createCommand()
						 ->insert('SproutFields_address', $attributes);
	}

	public function updateAddressField($id, $attributes)
	{
		craft()->db->createCommand()
		->update('SproutFields_address',
			$attributes,
			'id = :id', array(':id' => $id)
		);

	}

	public function deleteAddressById($id = null)
	{
		$record = new SproutFields_AddressRecord;
			
		// @TODO is this the right way to do this?  
		// Would this actually return true or false?
		return $record->deleteByPk($id);

	}
}