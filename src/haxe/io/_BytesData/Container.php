<?php
/**
 * Generated by Haxe 4.0.5
 */

namespace haxe\io\_BytesData;

use \php\Boot;

class Container {
	/**
	 * @var mixed
	 */
	public $s;

	/**
	 * @param mixed $s
	 * 
	 * @return void
	 */
	public function __construct ($s) {
		$this->s = $s;
	}
}

Boot::registerClass(Container::class, 'haxe.io._BytesData.Container');
