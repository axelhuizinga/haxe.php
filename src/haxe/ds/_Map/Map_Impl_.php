<?php
/**
 * Generated by Haxe 4.1.0
 */

namespace haxe\ds\_Map;

use \php\Boot;
use \haxe\ds\ObjectMap;
use \haxe\ds\IntMap;
use \haxe\IMap;
use \haxe\ds\StringMap;
use \haxe\ds\EnumValueMap;

final class Map_Impl_ {
	/**
	 * @param IMap $this
	 * @param mixed $k
	 * @param mixed $v
	 * 
	 * @return mixed
	 */
	public static function arrayWrite ($this1, $k, $v) {
		$this1->set($k, $v);
		return $v;
	}

	/**
	 * Removes all keys from `this` Map.
	 * 
	 * @param IMap $this
	 * 
	 * @return void
	 */
	public static function clear ($this1) {
		$this1->clear();
	}

	/**
	 * Returns a shallow copy of `this` map.
	 * The order of values is undefined.
	 * 
	 * @param IMap $this
	 * 
	 * @return IMap
	 */
	public static function copy ($this1) {
		return $this1->copy();
	}

	/**
	 * Returns true if `key` has a mapping, false otherwise.
	 * If `key` is `null`, the result is unspecified.
	 * 
	 * @param IMap $this
	 * @param mixed $key
	 * 
	 * @return bool
	 */
	public static function exists ($this1, $key) {
		return $this1->exists($key);
	}

	/**
	 * @param IntMap $map
	 * 
	 * @return IntMap
	 */
	public static function fromIntMap ($map) {
		return $map;
	}

	/**
	 * @param ObjectMap $map
	 * 
	 * @return ObjectMap
	 */
	public static function fromObjectMap ($map) {
		return $map;
	}

	/**
	 * @param StringMap $map
	 * 
	 * @return StringMap
	 */
	public static function fromStringMap ($map) {
		return $map;
	}

	/**
	 * Returns the current mapping of `key`.
	 * If no such mapping exists, `null` is returned.
	 * Note that a check like `map.get(key) == null` can hold for two reasons:
	 * 1. the map has no mapping for `key`
	 * 2. the map has a mapping with a value of `null`
	 * If it is important to distinguish these cases, `exists()` should be
	 * used.
	 * If `key` is `null`, the result is unspecified.
	 * 
	 * @param IMap $this
	 * @param mixed $key
	 * 
	 * @return mixed
	 */
	public static function get ($this1, $key) {
		return $this1->get($key);
	}

	/**
	 * Returns an Iterator over the values of `this` Map.
	 * The order of values is undefined.
	 * 
	 * @param IMap $this
	 * 
	 * @return object
	 */
	public static function iterator ($this1) {
		return $this1->iterator();
	}

	/**
	 * Returns an Iterator over the keys and values of `this` Map.
	 * The order of values is undefined.
	 * 
	 * @param IMap $this
	 * 
	 * @return object
	 */
	public static function keyValueIterator ($this1) {
		return $this1->keyValueIterator();
	}

	/**
	 * Returns an Iterator over the keys of `this` Map.
	 * The order of keys is undefined.
	 * 
	 * @param IMap $this
	 * 
	 * @return object
	 */
	public static function keys ($this1) {
		return $this1->keys();
	}

	/**
	 * Removes the mapping of `key` and returns true if such a mapping existed,
	 * false otherwise.
	 * If `key` is `null`, the result is unspecified.
	 * 
	 * @param IMap $this
	 * @param mixed $key
	 * 
	 * @return bool
	 */
	public static function remove ($this1, $key) {
		return $this1->remove($key);
	}

	/**
	 * Maps `key` to `value`.
	 * If `key` already has a mapping, the previous value disappears.
	 * If `key` is `null`, the result is unspecified.
	 * 
	 * @param IMap $this
	 * @param mixed $key
	 * @param mixed $value
	 * 
	 * @return void
	 */
	public static function set ($this1, $key, $value) {
		$this1->set($key, $value);
	}

	/**
	 * @param IMap $t
	 * 
	 * @return EnumValueMap
	 */
	public static function toEnumValueMapMap ($t) {
		return new EnumValueMap();
	}

	/**
	 * @param IMap $t
	 * 
	 * @return IntMap
	 */
	public static function toIntMap ($t) {
		return new IntMap();
	}

	/**
	 * @param IMap $t
	 * 
	 * @return ObjectMap
	 */
	public static function toObjectMap ($t) {
		return new ObjectMap();
	}

	/**
	 * Returns a String representation of `this` Map.
	 * The exact representation depends on the platform and key-type.
	 * 
	 * @param IMap $this
	 * 
	 * @return string
	 */
	public static function toString ($this1) {
		return $this1->toString();
	}

	/**
	 * @param IMap $t
	 * 
	 * @return StringMap
	 */
	public static function toStringMap ($t) {
		return new StringMap();
	}
}

Boot::registerClass(Map_Impl_::class, 'haxe.ds._Map.Map_Impl_');
