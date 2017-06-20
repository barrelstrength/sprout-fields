<?php
namespace barrelstrength\sproutfields\services;

use craft\base\Component;
use barrelstrength\sproutcore\services\sproutfields\Utilities;
use barrelstrength\sproutcore\services\sproutfields\Link;
use barrelstrength\sproutcore\services\sproutfields\Phone;

class Api extends Component
{
	public $phone;
	public $utilities;
	public $email;
	public $link;
	public $regularExpression;

	public function init()
	{
		$this->phone             = new Phone();
		$this->utilities         = new Utilities();
		$this->email             = new Email();
		$this->link              = new Link();
		$this->regularExpression = new RegularExpression();
	}
}