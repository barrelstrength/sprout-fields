<?php
namespace barrelstrength\sproutfields\controllers;

use Craft;
use craft\web\Controller as BaseController;

use barrelstrength\sproutfields\SproutFields;

class SproutFieldsController extends BaseController
{
	protected $allowAnonymous = ['actionSproutAddress'];

	public function actionLinkValidate()
	{
		$this->requirePostRequest();
		$this->requireAcceptsJson();

		$value        = Craft::$app->getRequest()->getParam('value');
		$fieldContext = Craft::$app->getRequest()->getParam('fieldContext');
		$fieldHandle  = Craft::$app->getRequest()->getParam('fieldHandle');
		$field        = Craft::$app->fields->getFieldByHandle($fieldHandle);

		$oldFieldContext = Craft::$app->content->fieldContext;
		Craft::$app->content->fieldContext = $fieldContext;

		Craft::$app->content->fieldContext = $oldFieldContext;

		if (!SproutFields::$api->link->validate($value, $field))
		{
			return $this->asJson(false);
		}

		return $this->asJson(true);
	}

	public function actionRegularExpressionValidate()
	{
		$this->requirePostRequest();
		$this->requireAcceptsJson();

		$value        = Craft::$app->getRequest()->getParam('value');
		$fieldContext = Craft::$app->getRequest()->getParam('fieldContext');
		$fieldHandle  = Craft::$app->getRequest()->getParam('fieldHandle');
		$field        = Craft::$app->fields->getFieldByHandle($fieldHandle);

		$oldFieldContext = Craft::$app->content->fieldContext;

		Craft::$app->content->fieldContext = $fieldContext;

		Craft::$app->content->fieldContext = $oldFieldContext;

		if (!SproutFields::$api->regularExpression->validate($value, $field))
		{
			return $this->asJson(false);
		}

		return $this->asJson(true);
	}

	public function actionEmailValidate()
	{
		$this->requirePostRequest();
		$this->requireAcceptsJson();

		$value        = Craft::$app->getRequest()->getParam('value');
		$elementId    = Craft::$app->getRequest()->getParam('elementId');
		$fieldContext = Craft::$app->getRequest()->getParam('fieldContext');
		$fieldHandle  = Craft::$app->getRequest()->getParam('fieldHandle');

		$oldFieldContext = Craft::$app->content->fieldContext;
		Craft::$app->content->fieldContext = $fieldContext;

		$field = Craft::$app->fields->getFieldByHandle($fieldHandle);

		Craft::$app->content->fieldContext = $oldFieldContext;

		if (!SproutFields::$api->email->validate($value, $elementId, $field))
		{
			return $this->asJson(false);
		}

		return $this->asJson(true);
	}

	public function actionPhoneValidate()
	{
		$this->requirePostRequest();
		$this->requireAcceptsJson();

		$value = Craft::$app->getRequest()->getParam('value');
		$mask  = Craft::$app->getRequest()->getParam('mask');

		if (!SproutFields::$api->phone->validate($value, $mask))
		{
			return $this->asJson(false);
		}

		return $this->asJson(true);
	}
}
