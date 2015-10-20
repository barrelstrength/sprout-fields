<?php
namespace Craft;

class SproutFieldsController extends BaseController
{
	public function actionLinkValidate()
	{
		$this->requirePostRequest();
		$this->requireAjaxRequest();

		$value        = craft()->request->getRequiredPost('value');
		$fieldContext = craft()->request->getRequiredPost('fieldContext');
		$fieldHandle  = craft()->request->getRequiredPost('fieldHandle');
		$field = craft()->fields->getFieldByHandle($fieldHandle);

		$oldFieldContext = craft()->content->fieldContext;
		craft()->content->fieldContext = $fieldContext;

		$field = craft()->fields->getFieldByHandle($fieldHandle);
		
		craft()->content->fieldContext = $oldFieldContext;

		if (!craft()->sproutFields_linkField->validate($value, $field))
		{
			$this->returnJson(false);
		}

		$this->returnJson(true);
	}

	public function actionEmailValidate()
	{
		$this->requirePostRequest();
		$this->requireAjaxRequest();

		$value         = craft()->request->getRequiredPost('value');
		$elementId     = craft()->request->getRequiredPost('elementId');
		$fieldContext  = craft()->request->getRequiredPost('fieldContext');
		$fieldHandle   = craft()->request->getRequiredPost('fieldHandle');
		
		$oldFieldContext = craft()->content->fieldContext;
		craft()->content->fieldContext = $fieldContext;

		$field = craft()->fields->getFieldByHandle($fieldHandle);
		
		craft()->content->fieldContext = $oldFieldContext;

		if (!craft()->sproutFields_emailField->validate($value, $elementId, $field))
		{
			$this->returnJson(false);
		}

		$this->returnJson(true);
	}

	public function actionPhoneValidate()
	{
		$this->requirePostRequest();
		$this->requireAjaxRequest();

		$value = craft()->request->getRequiredPost('value');
		$mask  = craft()->request->getRequiredPost('mask');

		if (!craft()->sproutFields_phoneField->validate($value, $mask))
		{
			$this->returnJson(false);
		}

		$this->returnJson(true);
	}
}
