<?php
namespace Craft;

class SproutFieldsController extends BaseController
{
	public function actionLinkValidate()
	{
		$this->requirePostRequest();
		$this->requireAjaxRequest();

		$value       = craft()->request->getRequiredPost('value');
		$fieldHandle = craft()->request->getRequiredPost('fieldHandle');
		$field       = craft()->fields->getFieldByHandle($fieldHandle);

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
		$fieldHandle   = craft()->request->getRequiredPost('fieldHandle');
		$field         = craft()->fields->getFieldByHandle($fieldHandle);
		$customPattern = false;

		if (isset($field->settings['customPattern']))
		{
			$customPattern = $field->settings['customPattern'];
		}


		if (!craft()->sproutFields_emailField->validateEmailAddress($value, $customPattern))
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
