<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace haxe\macro;

use \php\Boot;
use \haxe\Exception;

/**
 * This error can be used to handle or produce compilation errors in macros.
 */
class Error extends Exception {
	/**
	 * @var object
	 * The position of the error.
	 */
	public $pos;

	/**
	 * Instantiates an error with given message and position.
	 * 
	 * @param string $message
	 * @param object $pos
	 * @param Exception $previous
	 * 
	 * @return void
	 */
	public function __construct ($message, $pos, $previous = null) {
		parent::__construct($message, $previous);
		$this->pos = $pos;
	}
}

Boot::registerClass(Error::class, 'haxe.macro.Error');
