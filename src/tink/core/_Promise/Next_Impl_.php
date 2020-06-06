<?php
/**
 * Generated by Haxe 4.1.1
 */

namespace tink\core\_Promise;

use \tink\core\_Future\SyncFuture;
use \php\Boot;
use \tink\core\Outcome;
use \tink\core\_Lazy\LazyConst;

final class Next_Impl_ {
	/**
	 * @param \Closure $a
	 * @param \Closure $b
	 * 
	 * @return \Closure
	 */
	public static function _chain ($a, $b) {
		return function ($v) use (&$b, &$a) {
			return Promise_Impl_::next($a($v), $b);
		};
	}

	/**
	 * @param \Closure $f
	 * 
	 * @return \Closure
	 */
	public static function ofSafe ($f) {
		return function ($x) use (&$f) {
			return new SyncFuture(new LazyConst($f($x)));
		};
	}

	/**
	 * @param \Closure $f
	 * 
	 * @return \Closure
	 */
	public static function ofSafeSync ($f) {
		return function ($x) use (&$f) {
			return new SyncFuture(new LazyConst(Outcome::Success($f($x))));
		};
	}

	/**
	 * @param \Closure $f
	 * 
	 * @return \Closure
	 */
	public static function ofSync ($f) {
		return function ($x) use (&$f) {
			return $f($x)->map(Boot::getStaticClosure(Outcome::class, 'Success'))->gather();
		};
	}
}

Boot::registerClass(Next_Impl_::class, 'tink.core._Promise.Next_Impl_');
