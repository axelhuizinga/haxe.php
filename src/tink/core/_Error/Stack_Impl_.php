<?php
/**
 * Generated by Haxe 4.1.1
 */

namespace tink\core\_Error;

use \php\Boot;

final class Stack_Impl_ {
	/**
	 * @param \Array_hx $this
	 * 
	 * @return string
	 */
	public static function toString ($this1) {
		return "Error stack not available. Compile with -D error_stack.";
	}
}

Boot::registerClass(Stack_Impl_::class, 'tink.core._Error.Stack_Impl_');