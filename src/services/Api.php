<?php
namespace barrelstrength\sproutfields\services;

use Craft;
use craft\base\Component;

class Api extends Component
{
	public $phone;
	public $utilities;
	public $email;
	public $link;

	public function init()
	{
		$this->phone     = new Phone();
		$this->utilities = new Utilities();
		$this->email     = new Email();
		$this->link      = new Link();
	}
}