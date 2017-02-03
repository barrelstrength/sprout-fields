<?php
namespace barrelstrength\sproutfields\assetbundles\phonefield;

use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

class PhoneFieldAsset extends AssetBundle
{
	public function init()
	{
		// define the path that your publishable resources live
		$this->sourcePath = '@barrelstrength/sproutfields/assetbundles/phonefield/dist';

		// define the dependencies
		$this->depends = [
			CpAsset::class,
		];

		// define the relative path to CSS/JS files that should be registered with the page
		// when this asset bundle is registered
		$this->js = [
			'js/inputmask.js',
			'js/jquery.inputmask.js',
			'js/PhoneInputMask.js',
			'js/PhoneInputMask.js',
		];

		$this->css = [
			'css/sproutfields.css',
		];

		parent::init();
	}
}