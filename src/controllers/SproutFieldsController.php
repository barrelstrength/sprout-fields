<?php
namespace barrelstrength\sproutfields\controllers;

use Craft;
use craft\base\Field;
use craft\web\Controller as BaseController;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\ServerErrorHttpException;

use barrelstrength\sproutfields\SproutFields;

class SproutFieldsController extends BaseController
{

	protected $allowAnonymous = ['actionSproutAddress'];

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();
		$this->defaultAction = 'load-bucket-data';
	}

	public function actionLinkValidate()
	{
		$this->requirePostRequest();
		$this->requireAcceptsJson();

		$value        = Craft::$app->getRequest()->getRequiredBodyParam('value');
		$fieldContext = Craft::$app->getRequest()->getRequiredBodyParam('fieldContext');
		$fieldHandle  = Craft::$app->getRequest()->getRequiredBodyParam('fieldHandle');
		$field        = Craft::$app->fields->getFieldByHandle($fieldHandle);

		$oldFieldContext               = Craft::$app->content->fieldContext;
		Craft::$app->content->fieldContext = $fieldContext;

		$field = Craft::$app->fields->getFieldByHandle($fieldHandle);

		Craft::$app->content->fieldContext = $oldFieldContext;

		if (!sproutFields()->link->validate($value, $field))
		{
			$this->asJson(false);
		}

		$this->asJson(true);
	}

	public function actionRegularExpressionValidate()
	{
		$this->requirePostRequest();
		$this->requireAcceptsJson();

		$value        = Craft::$app->getRequest()->getRequiredBodyParam('value');
		$fieldContext = Craft::$app->getRequest()->getRequiredBodyParam('fieldContext');
		$fieldHandle  = Craft::$app->getRequest()->getRequiredBodyParam('fieldHandle');
		$field        = Craft::$app->fields->getFieldByHandle($fieldHandle);

		$oldFieldContext               = Craft::$app->content->fieldContext;
		Craft::$app->content->fieldContext = $fieldContext;

		$field = Craft::$app->fields->getFieldByHandle($fieldHandle);

		Craft::$app->content->fieldContext = $oldFieldContext;

		if (!sproutFields()->regularExpression->validate($value, $field))
		{
			$this->asJson(false);
		}

		$this->asJson(true);
	}

	public function actionEmailValidate()
	{
		$this->requirePostRequest();
		$this->requireAcceptsJson();

		$value        = Craft::$app->getRequest()->getRequiredBodyParam('value');
		$elementId    = Craft::$app->getRequest()->getRequiredBodyParam('elementId');
		$fieldContext = Craft::$app->getRequest()->getRequiredBodyParam('fieldContext');
		$fieldHandle  = Craft::$app->getRequest()->getRequiredBodyParam('fieldHandle');

		$oldFieldContext               = Craft::$app->content->fieldContext;
		Craft::$app->content->fieldContext = $fieldContext;

		$field = Craft::$app->fields->getFieldByHandle($fieldHandle);

		Craft::$app->content->fieldContext = $oldFieldContext;

		if (!sproutFields()->email->validate($value, $elementId, $field))
		{
			$this->asJson(false);
		}

		$this->asJson(true);
	}

	public function actionPhoneValidate()
	{
		$this->requirePostRequest();
		$this->requireAcceptsJson();

		$value = Craft::$app->getRequest()->getParam('value');
		$mask  = Craft::$app->getRequest()->getParam('mask');
		$plugin = SproutFields::$plugin;

		if (!SproutFields::$plugin->phone->validate($value, $mask))
		{
			return $this->asJson(false);
		}

		return $this->asJson(true);
	}

	public function actionTest()
	{
	
		$this->asJson(true);
	}

	public function actionSproutAddress()
	{
		$this->requirePostRequest();
		$this->requireAcceptsJson();

		$countryCode = Craft::$app->getRequest()->getPost('countryCode');

		$sproutAddress = Craft::$app->getRequest()->getPost('sproutAddress');
		$namespaceName = Craft::$app->getRequest()->getPost('sproutAddressNamespaceInputName');

		$addressField = Craft::$app->sproutFields_addressField->getAddress($sproutAddress);

		Craft::$app->sproutFields_addressFormField->setParams($countryCode, '', $sproutAddress, $addressField, $namespaceName);
		echo Craft::$app->sproutFields_addressFormField->setForm(true);
		exit;
	}
}
