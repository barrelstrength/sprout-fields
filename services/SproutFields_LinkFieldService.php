<?php
namespace Craft;

class SproutFields_LinkFieldService extends BaseApplicationComponent
{
	public function validate($value, $field)
	{
		$customPattern = $field->settings['customPattern'];

		if ($customPattern)
		{
			// Use backticks as delimiters as they are invalid characters for emails
			$customPattern = "`" . $customPattern . "`";

			if(preg_match($customPattern, $value))
			{
				return true;
			}
		}
		else
		{
			if ((!filter_var($value, FILTER_VALIDATE_URL) === false))
			{
				return true;
			}
		}

		return false;
	}		
}