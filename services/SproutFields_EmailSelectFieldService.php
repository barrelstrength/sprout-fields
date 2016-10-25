<?php
namespace Craft;

class SproutFields_EmailSelectFieldService extends BaseApplicationComponent
{
	/**
	 * @param      $options
	 * @param null $value
	 *
	 * @return mixed
	 */
	public function obfuscateEmailAddresses($options, $value = null)
	{
		foreach ($options as $key => $option)
		{
			$options[$key]['value'] = $key;

			if ($option['value'] == $value)
			{
				$options[$key]['selected'] = 1;
			}
			else
			{
				$options[$key]['selected'] = 0;
			}
		}

		return $options;
	}

	/**
	 * @param       $formId
	 * @param array $submittedFields
	 *
	 * @return bool
	 */
	public function unobfuscateEmailAddresses($formId, $submittedFields = array())
	{
		if (!is_numeric($formId))
		{
			return false;
		}

		$fieldContext = 'sproutForms:' . $formId;

		// Get all Email Select Fields for this form
		$emailSelectFieldHandles = craft()->db->createCommand()
			->select('handle')
			->from('fields')
			->where('context=:context', array(':context' => $fieldContext))
			->andWhere('type=:type', array(':type' => 'SproutFields_EmailSelect'))
			->queryColumn();

		$oldContext = craft()->content->fieldContext;

		craft()->content->fieldContext = $fieldContext;

		foreach ($emailSelectFieldHandles as $key => $handle)
		{
			if (isset($submittedFields[$handle]))
			{
				// Get our field settings, which include the map of
				// email addresses to their indexes
				$field   = craft()->fields->getFieldByHandle($handle);
				$options = $field->settings['options'];

				// Get the obfuscated email index from our post request
				$index      = $submittedFields[$handle];
				$emailValue = $options[$index]['value'];

				// Update the Email Select value in our post request from
				// the Email Index value to the Email Address
				$_POST['fields'][$handle] = $emailValue;
			}
		}

		craft()->content->fieldContext = $oldContext;
	}

	/**
	 * Handles event to unobfuscate email addresses in a Sprout Forms submission
	 *
	 * @param Event $event
	 */
	public function handleUnobfuscateEmailAddresses(Event $event)
	{
		if (craft()->request->isCpRequest())
		{
			return;
		}

		$formId          = $event->params['form']->id;
		$submittedFields = craft()->request->getPost('fields');

		// Unobfuscate email address in $_POST request
		$this->unobfuscateEmailAddresses($formId, $submittedFields);
	}
}
