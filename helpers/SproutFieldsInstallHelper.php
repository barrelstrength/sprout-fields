<?php

namespace Craft;

class SproutFieldsInstallHelper
{
	/**
	 * Make sure any Sprout Email and Sprout Link Fields get
	 * updated to use their Sprout Fields equivalents
	 *
	 * @return bool
	 */
	public function migrateSproutFields()
	{
		$fieldClassMap = array(
			'SproutEmailField_Email' => 'SproutFields_Email',
			'SproutLinkField_Link' => 'SproutFields_Link'
		);

		if (craft()->db->columnExists('fields', 'type'))
		{
			foreach ($fieldClassMap as $oldFieldClass => $newFieldClass)
			{
				$updated = craft()->db->createCommand()
					->update('fields', array(
						'type' => $newFieldClass
					), 'type = :class', array(':class' => $oldFieldClass));

				if ($updated)
				{
					SproutFieldsPlugin::log("Updated `$oldFieldClass` to `$newFieldClass` in the `fields` table.", LogLevel::Info, true);
				}
			}
		}
		else
		{
			SproutFieldsPlugin::log("No `fields` table found.", LogLevel::Info, true);
		}

		return true;
	}
}