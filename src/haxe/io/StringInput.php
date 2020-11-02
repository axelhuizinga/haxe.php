<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace haxe\io;

use \haxe\io\_BytesData\Container;
use \php\Boot;

class StringInput extends BytesInput {
	/**
	 * @param string $s
	 * 
	 * @return void
	 */
	public function __construct ($s) {
		$tmp = \strlen($s);
		parent::__construct(new Bytes($tmp, new Container($s)));
	}
}

Boot::registerClass(StringInput::class, 'haxe.io.StringInput');
