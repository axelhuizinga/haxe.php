<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace tink\io;

use \php\Boot;

class SimpleBytewiseParser extends BytewiseParser {
	/**
	 * @var \Closure
	 */
	public $_read;

	/**
	 * @param \Closure $f
	 * 
	 * @return void
	 */
	public function __construct ($f) {
		$this->_read = $f;
	}

	/**
	 * @param int $char
	 * 
	 * @return ParseStep
	 */
	public function read ($char) {
		return ($this->_read)($char);
	}
}

Boot::registerClass(SimpleBytewiseParser::class, 'tink.io.SimpleBytewiseParser');