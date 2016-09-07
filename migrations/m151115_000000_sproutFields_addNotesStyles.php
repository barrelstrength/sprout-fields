<?php
namespace Craft;

/**
 * The class name is the UTC timestamp in the format of mYYMMDD_HHMMSS_pluginHandle_migrationName
 */
class m151115_000000_sproutFields_addNotesStyles extends BaseMigration
{
	/**
	 * Any migration code in here is wrapped inside of a transaction.
	 *
	 * @return bool
	 */
	public function safeUp()
	{
		$defaultStyles = '{"infoPrimaryDocumentation":".field[id$=fields-{{ name }}-field] {\r\n\tbackground-color: #d9edf7;\r\n\tpadding: 10px;\r\n\tmax-width: 580px;\r\n}\r\n.field[id$=fields-{{ name }}-field] label {\r\n\tborder-bottom: 1px solid #bbd2dd;\r\n\tcolor: #000;\r\n\tdisplay: block;\r\n\tfont-size: 1.2em;\r\n\tpadding-bottom:.5em;\r\n\tmargin-bottom: .5em;\r\n}\r\n.field[id$=fields-{{ name }}-field] h2,\r\n.field[id$=fields-{{ name }}-field] h3 {\r\n\tborder-bottom: 1px solid #c8dae2;\r\n\tpadding: 0 0 .5em;\r\n}\r\n.field[id$=fields-{{ name }}-field] p {\r\n\tcolor: #232323;\r\n\tfont-size: 1em;\r\n}\r\n.field[id$=fields-{{ name }}-field] ul {\r\n        color: #232323;\r\n\tlist-style-type: disc;\r\n\tmargin: 0 0 1em 1.5em;\r\n}","infoSecondaryDocumentation":".field[id$=fields-{{ name }}-field] {\r\n\tbackground-color: #eee;\r\n\tpadding: 10px;\r\n\tmax-width: 580px;\r\n}\r\n.field[id$=fields-{{ name }}-field] label {\r\n\tborder-bottom: 1px solid #c6c6c6;\r\n\tcolor: #000;\r\n\tdisplay: block;\r\n\tfont-size: 1.2em;\r\n\tpadding-bottom:.5em;\r\n\tmargin-bottom: .5em;\r\n}\r\n.field[id$=fields-{{ name }}-field] h2,\r\n.field[id$=fields-{{ name }}-field] h3 {\r\n\tborder-bottom: 1px solid #dddddd;\r\n\tpadding: 0 0 .5em;\r\n}\r\n.field[id$=fields-{{ name }}-field] p {\r\n\tcolor: #232323;\r\n\tfont-size: 1em;\r\n}\r\n.field[id$=fields-{{ name }}-field] ul {\r\n        color: #232323;\r\n\tlist-style-type: disc;\r\n\tmargin: 0 0 1em 1.5em;\r\n}","warningDocumentation":".field[id$=fields-{{ name }}-field] {\r\n\tbackground-color: #fcf8e3;\r\n\tpadding: 10px;\r\n\tmax-width: 580px;\r\n}\r\n.field[id$=fields-{{ name }}-field] label {\r\n\tborder-bottom: 1px solid #e4d1b0;\r\n\tcolor: #000;\r\n\tdisplay: block;\r\n\tfont-size: 1.2em;\r\n\tpadding-bottom:.5em;\r\n\tmargin-bottom: .5em;\r\n}\r\n.field[id$=fields-{{ name }}-field] h2,\r\n.field[id$=fields-{{ name }}-field] h3 {\r\n\tborder-bottom: 1px solid #f7e9d1;\r\n\tpadding: 0 0 .5em;\r\n}\r\n.field[id$=fields-{{ name }}-field] p {\r\n\tcolor: #232323;\r\n\tfont-size: 1em;\r\n}\r\n.field[id$=fields-{{ name }}-field] ul {\r\n        color: #232323;\r\n\tlist-style-type: disc;\r\n\tmargin: 0 0 1em 1.5em;\r\n}","dangerDocumentation":".field[id$=fields-{{ name }}-field] {\r\n  \tbackground-color: #ffe1e1;\r\n\tpadding: 10px;\r\n\tmax-width: 580px;\r\n}\r\n.field[id$=fields-{{ name }}-field] label {\r\n\tborder-bottom: 1px solid #ddb9b9;\r\n\tcolor: #000;\r\n\tdisplay: block;\r\n\tfont-size: 1.2em;\r\n\tpadding-bottom:.5em;\r\n\tmargin-bottom: .5em;\r\n}\r\n.field[id$=fields-{{ name }}-field] h2,\r\n.field[id$=fields-{{ name }}-field] h3 {\r\n\tborder-bottom: 1px solid #f3cccc;\r\n\tpadding: 0 0 .5em;\r\n}\r\n.field[id$=fields-{{ name }}-field] p {\r\n\tcolor: #232323;\r\n\tfont-size: 1em;\r\n}\r\n.field[id$=fields-{{ name }}-field] ul {\r\n        color: #232323;\r\n\tlist-style-type: disc;\r\n\tmargin: 0 0 1em 1.5em;\r\n}","highlightDocumentation":".field[id$=fields-{{ name }}-field] {\r\n  \tbackground-color: #dbf7d9;\r\n\tpadding: 10px;\r\n\tmax-width: 580px;\r\n}\r\n.field[id$=fields-{{ name }}-field] label {\r\n\tborder-bottom: 1px solid #b6c8b5;\r\n\tcolor: #000;\r\n\tdisplay: block;\r\n\tfont-size: 1.2em;\r\n\tpadding-bottom:.5em;\r\n\tmargin-bottom: .5em;\r\n}\r\n.field[id$=fields-{{ name }}-field] h2,\r\n.field[id$=fields-{{ name }}-field] h3 {\r\n\tborder-bottom: 1px solid #c5e1c3;\r\n\tpadding: 0 0 .5em;\r\n}\r\n.field[id$=fields-{{ name }}-field] p {\r\n\tcolor: #232323;\r\n\tfont-size: 1em;\r\n}\r\n.field[id$=fields-{{ name }}-field] ul {\r\n        color: #232323;\r\n\tlist-style-type: disc;\r\n\tmargin: 0 0 1em 1.5em;\r\n}"}';

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

		SproutFieldsPlugin::log("Added default style settings for Notes Field", LogLevel::Info, true);

		return true;
	}
}
