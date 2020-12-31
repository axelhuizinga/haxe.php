<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace tink\core;

use \tink\core\_Lazy\LazyObject;
use \php\Boot;
use \haxe\Exception;
use \haxe\ds\Option as DsOption;

class OptionTools {
	/**
	 *  Returns `true` if the option is `Some` and the value is equal to `v`, otherwise `false`
	 * 
	 * @param DsOption $o
	 * @param mixed $v
	 * 
	 * @return bool
	 */
	public static function equals ($o, $v) {
		if ($o->index === 0) {
			return Boot::equal($o->params[0], $v);
		} else {
			return false;
		}
	}

	/**
	 *  Returns `Some(value)` if the option is `Some` and the filter function evaluates to `true`, otherwise `None`
	 * 
	 * @param DsOption $o
	 * @param \Closure $f
	 * 
	 * @return DsOption
	 */
	public static function filter ($o, $f) {
		if ($o->index === 0) {
			if ($f($o->params[0]) === false) {
				return DsOption::None();
			} else {
				return $o;
			}
		} else {
			return $o;
		}
	}

	/**
	 *  Transforms the option value with a transform function
	 *  Different from `map`, the transform function of `flatMap` returns an `Option`
	 * 
	 * @param DsOption $o
	 * @param \Closure $f
	 * 
	 * @return DsOption
	 */
	public static function flatMap ($o, $f) {
		if ($o->index === 0) {
			return $f($o->params[0]);
		} else {
			return DsOption::None();
		}
	}

	/**
	 *  Extracts the value if the option is `Some`, throws an `Error` otherwise
	 * 
	 * @param DsOption $o
	 * @param object $pos
	 * 
	 * @return mixed
	 */
	public static function force ($o, $pos = null) {
		if ($o->index === 0) {
			return $o->params[0];
		} else {
			throw Exception::thrown(new TypedError(404, "Some value expected but none found", $pos));
		}
	}

	/**
	 *  Creates an iterator from the option.
	 *  The iterator has one item if the option is `Some`, and no items if it is `None`
	 * 
	 * @param DsOption $o
	 * 
	 * @return OptionIter
	 */
	public static function iterator ($o) {
		return new OptionIter($o);
	}

	/**
	 *  Transforms the option value with a transform function
	 *  Different from `flatMap`, the transform function of `map` returns a plain value
	 * 
	 * @param DsOption $o
	 * @param \Closure $f
	 * 
	 * @return DsOption
	 */
	public static function map ($o, $f) {
		if ($o->index === 0) {
			return DsOption::Some($f($o->params[0]));
		} else {
			return DsOption::None();
		}
	}

	/**
	 *  Extracts the value if the option is `Some`, uses the fallback value otherwise
	 * 
	 * @param DsOption $o
	 * @param LazyObject $l
	 * 
	 * @return mixed
	 */
	public static function or ($o, $l) {
		if ($o->index === 0) {
			return $o->params[0];
		} else {
			return $l->get();
		}
	}

	/**
	 *  Extracts the value if the option is `Some`, otherwise `null`
	 * 
	 * @param DsOption $o
	 * 
	 * @return mixed
	 */
	public static function orNull ($o) {
		if ($o->index === 0) {
			return $o->params[0];
		} else {
			return null;
		}
	}

	/**
	 *  Returns `true` if the option is `Some` and the filter function evaluates to `true`, otherwise `false`
	 * 
	 * @param DsOption $o
	 * @param \Closure $f
	 * 
	 * @return bool
	 */
	public static function satisfies ($o, $f) {
		if ($o->index === 0) {
			return $f($o->params[0]);
		} else {
			return false;
		}
	}

	/**
	 *  Creates an array from the option.
	 *  The array has one item if the option is `Some`, and no items if it is `None`
	 * 
	 * @param DsOption $o
	 * 
	 * @return \Array_hx
	 */
	public static function toArray ($o) {
		if ($o->index === 0) {
			return \Array_hx::wrap([$o->params[0]]);
		} else {
			return new \Array_hx();
		}
	}
}

Boot::registerClass(OptionTools::class, 'tink.core.OptionTools');
