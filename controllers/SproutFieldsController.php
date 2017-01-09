<?php
namespace Craft;

class SproutFieldsController extends BaseController
{

	protected $allowAnonymous = array('actionSproutAddress');

	public function actionLinkValidate()
	{
		$this->requirePostRequest();
		$this->requireAjaxRequest();

		$value        = craft()->request->getRequiredPost('value');
		$fieldContext = craft()->request->getRequiredPost('fieldContext');
		$fieldHandle  = craft()->request->getRequiredPost('fieldHandle');
		$field        = craft()->fields->getFieldByHandle($fieldHandle);

		$oldFieldContext               = craft()->content->fieldContext;
		craft()->content->fieldContext = $fieldContext;

		$field = craft()->fields->getFieldByHandle($fieldHandle);

		craft()->content->fieldContext = $oldFieldContext;

		if (!sproutFields()->link->validate($value, $field))
		{
			$this->returnJson(false);
		}

		$this->returnJson(true);
	}

	public function actionRegularExpressionValidate()
	{
		$this->requirePostRequest();
		$this->requireAjaxRequest();

		$value        = craft()->request->getRequiredPost('value');
		$fieldContext = craft()->request->getRequiredPost('fieldContext');
		$fieldHandle  = craft()->request->getRequiredPost('fieldHandle');
		$field        = craft()->fields->getFieldByHandle($fieldHandle);

		$oldFieldContext               = craft()->content->fieldContext;
		craft()->content->fieldContext = $fieldContext;

		$field = craft()->fields->getFieldByHandle($fieldHandle);

		craft()->content->fieldContext = $oldFieldContext;

		if (!sproutFields()->regularExpression->validate($value, $field))
		{
			$this->returnJson(false);
		}

		$this->returnJson(true);
	}

	public function actionEmailValidate()
	{
		$this->requirePostRequest();
		$this->requireAjaxRequest();

		$value        = craft()->request->getRequiredPost('value');
		$elementId    = craft()->request->getRequiredPost('elementId');
		$fieldContext = craft()->request->getRequiredPost('fieldContext');
		$fieldHandle  = craft()->request->getRequiredPost('fieldHandle');

		$oldFieldContext               = craft()->content->fieldContext;
		craft()->content->fieldContext = $fieldContext;

		$field = craft()->fields->getFieldByHandle($fieldHandle);

		craft()->content->fieldContext = $oldFieldContext;

		if (!sproutFields()->email->validate($value, $elementId, $field))
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

		if (!sproutFields()->phone->validate($value, $mask))
		{
			$this->returnJson(false);
		}

		$this->returnJson(true);
	}

	public function actionSproutAddress()
	{
		$this->requirePostRequest();
		$this->requireAjaxRequest();

		$countryCode = craft()->request->getPost('countryCode');

		$sproutAddress = craft()->request->getPost('sproutAddress');
		$namespaceName = craft()->request->getPost('sproutAddressNamespaceInputName');

		$addressField = craft()->sproutFields_addressField->getAddress($sproutAddress);

		craft()->sproutFields_addressFormField->setParams($countryCode, '', $sproutAddress, $addressField, $namespaceName);
		echo craft()->sproutFields_addressFormField->setForm(true);
		exit;
	}
}
