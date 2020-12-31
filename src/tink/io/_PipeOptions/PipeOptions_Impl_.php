<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace tink\io\_PipeOptions;

use \php\Boot;

final class PipeOptions_Impl_ {

	/**
	 * @param object $this
	 * 
	 * @return bool
	 */
	public static function get_destructive ($this1) {
		if ($this1 !== null) {
			return $this1->destructive;
		} else {
			return false;
		}
	}

	/**
	 * @param object $this
	 * 
	 * @return bool
	 */
	public static function get_end ($this1) {
		if ($this1 !== null) {
			return $this1->end;
		} else {
			return false;
		}
	}
}

Boot::registerClass(PipeOptions_Impl_::class, 'tink.io._PipeOptions.PipeOptions_Impl_');
Boot::registerGetters('tink\\io\\_PipeOptions\\PipeOptions_Impl_', [
	'destructive' => true,
	'end' => true
]);
