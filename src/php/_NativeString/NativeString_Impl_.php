<?php
/**
 * Generated by Haxe 4.0.5
 */

namespace php\_NativeString;

use \php\Boot;
use \php\NativeStringKeyValueIterator;
use \php\NativeStringIterator;

final class NativeString_Impl_ {
	/**
	 * @param mixed $this
	 * @param int $key
	 * 
	 * @return string
	 */
	public static function get ($this, $key) ;

	/**
	 * @param mixed $this
	 * 
	 * @return NativeStringIterator
	 */
	public static function iterator ($this1) {
		#C:\Program Files\Haxe\haxe\std/php/NativeString.hx:34: characters 3-40
		return new NativeStringIterator($this1);
	}

	/**
	 * @param mixed $this
	 * 
	 * @return NativeStringKeyValueIterator
	 */
	public static function keyValueIterator ($this1) {
		#C:\Program Files\Haxe\haxe\std/php/NativeString.hx:38: characters 3-48
		return new NativeStringKeyValueIterator($this1);
	}

	/**
	 * @param mixed $this
	 * @param int $key
	 * @param string $val
	 * 
	 * @return string
	 */
	public static function set ($this, $key, $val) ;
}

Boot::registerClass(NativeString_Impl_::class, 'php._NativeString.NativeString_Impl_');
