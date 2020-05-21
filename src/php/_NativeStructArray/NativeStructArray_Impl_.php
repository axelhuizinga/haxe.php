<?php
/**
 * Generated by Haxe 4.1.0
 */

namespace php\_NativeStructArray;

use \php\_Boot\HxAnon;
use \php\Boot;

final class NativeStructArray_Impl_ {
	/**
	 * @param mixed $obj
	 * 
	 * @return mixed
	 */
	public static function __fromObject ($obj) {
		return ((array)($obj));
	}

	/**
	 * @param mixed $this
	 * 
	 * @return mixed
	 */
	public static function __toObject ($this1) {
		return new HxAnon($this1);
	}

	/**
	 * @param mixed $this
	 * @param string $key
	 * 
	 * @return mixed
	 */
	public static function get ($this1, $key) {
		return $this1[$key];
	}

	/**
	 * @param mixed $this
	 * @param string $key
	 * @param mixed $val
	 * 
	 * @return mixed
	 */
	public static function set ($this1, $key, $val) {
		return $this1[$key] = $val;
	}
}

Boot::registerClass(NativeStructArray_Impl_::class, 'php._NativeStructArray.NativeStructArray_Impl_');
