<?php
/**
 * Generated by Haxe 4.0.5
 */

namespace haxe\_Int64;

use \php\Boot;

class ___Int64 {
	/**
	 * @var int
	 */
	public $high;
	/**
	 * @var int
	 */
	public $low;

	/**
	 * @param int $high
	 * @param int $low
	 * 
	 * @return void
	 */
	public function __construct ($high, $low) {
		$this->high = $high;
		$this->low = $low;
	}

	/**
	 * We also define toString here to ensure we always get a pretty string
	 * when tracing or calling `Std.string`. This tends not to happen when
	 * `toString` is only in the abstract.
	 * 
	 * @return string
	 */
	public function toString () {
		return Int64_Impl_::toString($this);
	}

	public function __toString() {
		return $this->toString();
	}
}

Boot::registerClass(___Int64::class, 'haxe._Int64.___Int64');
