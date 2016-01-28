<?php

namespace Craft;

class SproutFieldsInstallHelper
{

	/**
	 * Install default styles to be used with Notes Field
	 *
	 * @return none
	 */
	public function installDefaultNotesStyles()
	{
		$defaultStyles = '{"infoPrimaryDocumentation":".field[id$=fields-{{ name }}-field] {\r\n  background-color: #d9edf7;\r\n  padding: 10px;\r\n}\r\n.field[id$=fields-{{ name }}-field] label {\r\n  color: #000;\r\n  cursor: pointer;\r\n  display: block;\r\n  font-size: 1em;\r\n  font-weight: bold;\r\n}\r\n.field[id$=fields-{{ name }}-field] .input {\r\n  border-top: 1px solid #bbd2dd;\r\n  padding-top:.5em;\r\n  margin-top: .5em;\r\n}\r\n.field[id$=fields-{{ name }}-field] h1,\r\n.field[id$=fields-{{ name }}-field] h2,\r\n.field[id$=fields-{{ name }}-field] h3 {\r\n  color: #29323d;\r\n  font-size: 1em;\r\n  font-weight: bold;\r\n}\r\n.field[id$=fields-{{ name }}-field] h1,\r\n.field[id$=fields-{{ name }}-field] h2 {\r\n  border-bottom: 1px solid #c8dae2;\r\n  font-weight: bold;\r\n  padding: 0 0 .5em;\r\n  margin: .5em 0;\r\n}\r\n.field[id$=fields-{{ name }}-field] h1 {\r\n  text-transform: uppercase;\r\n}\r\n.field[id$=fields-{{ name }}-field] h3 {\r\n  color: #444;\r\n  margin-bottom: .2em;\r\n}\r\n.field[id$=fields-{{ name }}-field] h3 + p {\r\n  margin-top: 0;\r\n  padding-top: 0;\r\n}\r\n.field[id$=fields-{{ name }}-field] p {\r\n  color: #232323;\r\n  font-size: 1em;\r\n}\r\n.field[id$=fields-{{ name }}-field] ul {\r\n  color: #232323;\r\n  list-style-type: disc;\r\n  margin: 0 0 1em 3em;\r\n}","infoSecondaryDocumentation":".field[id$=fields-{{ name }}-field] {\r\n  background-color: #eee;\r\n  padding: 10px;\r\n}\r\n.field[id$=fields-{{ name }}-field] label {\r\n  color: #000;\r\n  cursor: pointer;\r\n  display: block;\r\n  font-size: 1em;\r\n  font-weight: bold;\r\n}\r\n.field[id$=fields-{{ name }}-field] .input {\r\n  border-top: 1px solid #c6c6c6;\r\n  padding-top:.5em;\r\n  margin-top: .5em;\r\n}\r\n.field[id$=fields-{{ name }}-field] h1,\r\n.field[id$=fields-{{ name }}-field] h2,\r\n.field[id$=fields-{{ name }}-field] h3 {\r\n  color: #29323d;\r\n  font-size: 1em;\r\n  font-weight: bold;\r\n}\r\n.field[id$=fields-{{ name }}-field] h1,\r\n.field[id$=fields-{{ name }}-field] h2 {\r\n  border-bottom: 1px solid #dddddd;\r\n  font-weight: bold;\r\n  padding: 0 0 .5em;\r\n  margin: .5em 0;\r\n}\r\n.field[id$=fields-{{ name }}-field] h1 {\r\n  text-transform: uppercase;\r\n}\r\n.field[id$=fields-{{ name }}-field] h3 {\r\n  color: #444;\r\n  margin-bottom: .2em;\r\n}\r\n.field[id$=fields-{{ name }}-field] h3 + p {\r\n  margin-top: 0;\r\n  padding-top: 0;\r\n}\r\n.field[id$=fields-{{ name }}-field] p {\r\n  color: #232323;\r\n  font-size: 1em;\r\n}\r\n.field[id$=fields-{{ name }}-field] ul {\r\n  color: #232323;\r\n  list-style-type: disc;\r\n  margin: 0 0 1em 3em;\r\n}","warningDocumentation":".field[id$=fields-{{ name }}-field] {\r\n  background-color: #fcf8e3;\r\n  padding: 10px;\r\n}\r\n.field[id$=fields-{{ name }}-field] label {\r\n  color: #000;\r\n  cursor: pointer;\r\n  display: block;\r\n  font-size: 1em;\r\n  font-weight: bold;\r\n}\r\n.field[id$=fields-{{ name }}-field] .input {\r\n  border-top: 1px solid #e4d1b0;\r\n  padding-top:.5em;\r\n  margin-top: .5em;\r\n}\r\n.field[id$=fields-{{ name }}-field] h1,\r\n.field[id$=fields-{{ name }}-field] h2,\r\n.field[id$=fields-{{ name }}-field] h3 {\r\n  color: #29323d;\r\n  font-size: 1em;\r\n  font-weight: bold;\r\n}\r\n.field[id$=fields-{{ name }}-field] h1,\r\n.field[id$=fields-{{ name }}-field] h2 {\r\n  border-bottom: 1px solid #f7e9d1;\r\n  font-weight: bold;\r\n  padding: 0 0 .5em;\r\n  margin: .5em 0;\r\n}\r\n.field[id$=fields-{{ name }}-field] h1 {\r\n  text-transform: uppercase;\r\n}\r\n.field[id$=fields-{{ name }}-field] h3 {\r\n  color: #444;\r\n  margin-bottom: .2em;\r\n}\r\n.field[id$=fields-{{ name }}-field] h3 + p {\r\n  margin-top: 0;\r\n  padding-top: 0;\r\n}\r\n.field[id$=fields-{{ name }}-field] p {\r\n  color: #232323;\r\n  font-size: 1em;\r\n}\r\n.field[id$=fields-{{ name }}-field] ul {\r\n  color: #232323;\r\n  list-style-type: disc;\r\n  margin: 0 0 1em 3em;\r\n}","dangerDocumentation":".field[id$=fields-{{ name }}-field] {\r\n  background-color: #ffe1e1;\r\n  padding: 10px;\r\n}\r\n.field[id$=fields-{{ name }}-field] label {\r\n  color: #000;\r\n  cursor: pointer;\r\n  display: block;\r\n  font-size: 1em;\r\n  font-weight: bold;\r\n}\r\n.field[id$=fields-{{ name }}-field] .input {\r\n  border-top: 1px solid #ddb9b9;\r\n  padding-top:.5em;\r\n  margin-top: .5em;\r\n}\r\n.field[id$=fields-{{ name }}-field] h1,\r\n.field[id$=fields-{{ name }}-field] h2,\r\n.field[id$=fields-{{ name }}-field] h3 {\r\n  color: #29323d;\r\n  font-size: 1em;\r\n  font-weight: bold;\r\n}\r\n.field[id$=fields-{{ name }}-field] h1,\r\n.field[id$=fields-{{ name }}-field] h2 {\r\n  border-bottom: 1px solid #f3cccc;\r\n  font-weight: bold;\r\n  padding: 0 0 .5em;\r\n  margin: .5em 0;\r\n}\r\n.field[id$=fields-{{ name }}-field] h1 {\r\n  text-transform: uppercase;\r\n}\r\n.field[id$=fields-{{ name }}-field] h3 {\r\n  color: #444;\r\n  margin-bottom: .2em;\r\n}\r\n.field[id$=fields-{{ name }}-field] h3 + p {\r\n  margin-top: 0;\r\n  padding-top: 0;\r\n}\r\n.field[id$=fields-{{ name }}-field] p {\r\n  color: #232323;\r\n  font-size: 1em;\r\n}\r\n.field[id$=fields-{{ name }}-field] ul {\r\n  color: #232323;\r\n  list-style-type: disc;\r\n  margin: 0 0 1em 3em;\r\n}","highlightDocumentation":".field[id$=fields-{{ name }}-field] {\r\n  background-color: #dbf7d9;\r\n  padding: 10px;\r\n}\r\n.field[id$=fields-{{ name }}-field] label {\r\n  color: #000;\r\n  cursor: pointer;\r\n  display: block;\r\n  font-size: 1em;\r\n  font-weight: bold;\r\n}\r\n.field[id$=fields-{{ name }}-field] .input {\r\n  border-top: 1px solid #b6c8b5;\r\n  padding-top:.5em;\r\n  margin-top: .5em;\r\n}\r\n.field[id$=fields-{{ name }}-field] h1,\r\n.field[id$=fields-{{ name }}-field] h2,\r\n.field[id$=fields-{{ name }}-field] h3 {\r\n  color: #29323d;\r\n  font-size: 1em;\r\n  font-weight: bold;\r\n}\r\n.field[id$=fields-{{ name }}-field] h1,\r\n.field[id$=fields-{{ name }}-field] h2 {\r\n  border-bottom: 1px solid #c5e1c3;\r\n  font-weight: bold;\r\n  padding: 0 0 .5em;\r\n  margin: .5em 0;\r\n}\r\n.field[id$=fields-{{ name }}-field] h1 {\r\n  text-transform: uppercase;\r\n}\r\n.field[id$=fields-{{ name }}-field] h3 {\r\n  color: #444;\r\n  margin-bottom: .2em;\r\n}\r\n.field[id$=fields-{{ name }}-field] h3 + p {\r\n  margin-top: 0;\r\n  padding-top: 0;\r\n}\r\n.field[id$=fields-{{ name }}-field] p {\r\n  color: #232323;\r\n  font-size: 1em;\r\n}\r\n.field[id$=fields-{{ name }}-field] ul {\r\n  color: #232323;\r\n  list-style-type: disc;\r\n  margin: 0 0 1em 3em;\r\n}"}';

		craft()->db->createCommand()->update(
			'plugins',
			array(
				'settings' => $defaultStyles
			),
			'class=:class',
			array(
				':class' => 'SproutFields'
			)
		);
	}

	/**
	 * Make sure any Sprout Email and Sprout Link Fields get
	 * updated to use their Sprout Fields equivalents
	 *
	 * @return bool
	 */
	public function migrateSproutFields()
	{
		$fieldClassMap = array(
			'SproutEmailField_Email'  => 'SproutFields_Email',
			'SproutLinkField_Link'    => 'SproutFields_Link',
			'SproutMoreInfo_MoreInfo' => 'SproutFields_Notes',
			'MoreInfo_MoreInfo'       => 'SproutFields_Notes'
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
