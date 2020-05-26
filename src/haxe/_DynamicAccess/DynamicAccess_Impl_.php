<?php
/**
 * Generated by Haxe 4.1.1
 */

namespace haxe\_DynamicAccess;

use \php\_Boot\HxAnon;
use \php\Boot;
use \haxe\iterators\DynamicAccessIterator;
use \haxe\iterators\DynamicAccessKeyValueIterator;

final class DynamicAccess_Impl_ {
	/**
	 * Creates a new structure.
	 * 
	 * @return mixed
	 */
	public static function _new () {
		return new HxAnon();
	}

	/**
	 * Returns a shallow copy of the structure
	 * 
	 * @param mixed $this
	 * 
	 * @return mixed
	 */
	public static function copy ($this1) {
		return \Reflect::copy($this1);
	}

	/**
	 * Tells if the structure contains a specified `key`.
	 * If `key` is `null`, the result is unspecified.
	 * 
	 * @param mixed $this
	 * @param string $key
	 * 
	 * @return bool
	 */
	public static function exists ($this1, $key) {
		return \Reflect::hasField($this1, $key);
	}

	/**
	 * Returns a value by specified `key`.
	 * If the structure does not contain the given key, `null` is returned.
	 * If `key` is `null`, the result is unspecified.
	 * 
	 * @param mixed $this
	 * @param string $key
	 * 
	 * @return mixed
	 */
	public static function get ($this1, $key) {
		return \Reflect::field($this1, $key);
	}

	/**
	 * Returns an Iterator over the values of this `DynamicAccess`.
	 * The order of values is undefined.
	 * 
	 * @param mixed $this
	 * 
	 * @return DynamicAccessIterator
	 */
	public static function iterator ($this1) {
		return new DynamicAccessIterator($this1);
	}

	/**
	 * Returns an Iterator over the keys and values of this `DynamicAccess`.
	 * The order of values is undefined.
	 * 
	 * @param mixed $this
	 * 
	 * @return DynamicAccessKeyValueIterator
	 */
	public static function keyValueIterator ($this1) {
		return new DynamicAccessKeyValueIterator($this1);
	}

	/**
	 * Returns an array of `keys` in a structure.
	 * 
	 * @param mixed $this
	 * 
	 * @return \Array_hx
	 */
	public static function keys ($this1) {
		return \Reflect::fields($this1);
	}

	/**
	 * Removes a specified `key` from the structure.
	 * Returns true, if `key` was present in structure, or false otherwise.
	 * If `key` is `null`, the result is unspecified.
	 * 
	 * @param mixed $this
	 * @param string $key
	 * 
	 * @return bool
	 */
	public static function remove ($this1, $key) {
		return \Reflect::deleteField($this1, $key);
	}

	/**
	 * Sets a `value` for a specified `key`.
	 * If the structure contains the given key, its value will be overwritten.
	 * Returns the given value.
	 * If `key` is `null`, the result is unspecified.
	 * 
	 * @param mixed $this
	 * @param string $key
	 * @param mixed $value
	 * 
	 * @return mixed
	 */
	public static function set ($this1, $key, $value) {
		\Reflect::setField($this1, $key, $value);
		return $value;
	}
}

Boot::registerClass(DynamicAccess_Impl_::class, 'haxe._DynamicAccess.DynamicAccess_Impl_');
