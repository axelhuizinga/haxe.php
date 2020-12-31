<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace haxe\ds;

use \php\Boot;
use \haxe\iterators\MapKeyValueIterator;
use \haxe\IMap;
use \php\_NativeIndexedArray\NativeIndexedArrayIterator;

/**
 * ObjectMap allows mapping of object keys to arbitrary values.
 * On static targets, the keys are considered to be strong references. Refer
 * to `haxe.ds.WeakMap` for a weak reference version.
 * See `Map` for documentation details.
 * @see https://haxe.org/manual/std-Map.html
 */
class ObjectMap implements IMap {
	/**
	 * @var mixed
	 */
	public $_keys;
	/**
	 * @var mixed
	 */
	public $_values;

	/**
	 * Creates a new ObjectMap.
	 * 
	 * @return void
	 */
	public function __construct () {
		$this->_keys = [];
		$this->_values = [];
	}

	/**
	 * See `Map.clear`
	 * 
	 * @return void
	 */
	public function clear () {
		$this->_keys = [];
		$this->_values = [];
	}

	/**
	 * See `Map.copy`
	 * 
	 * @return ObjectMap
	 */
	public function copy () {
		return (clone $this);
	}

	/**
	 * See `Map.exists`
	 * 
	 * @param mixed $key
	 * 
	 * @return bool
	 */
	public function exists ($key) {
		return \array_key_exists(\spl_object_hash($key), $this->_values);
	}

	/**
	 * See `Map.get`
	 * 
	 * @param mixed $key
	 * 
	 * @return mixed
	 */
	public function get ($key) {
		$id = \spl_object_hash($key);
		if (isset($this->_values[$id])) {
			return $this->_values[$id];
		} else {
			return null;
		}
	}

	/**
	 * See `Map.iterator`
	 * (cs, java) Implementation detail: Do not `set()` any new value while
	 * iterating, as it may cause a resize, which will break iteration.
	 * 
	 * @return object
	 */
	public function iterator () {
		return new NativeIndexedArrayIterator(\array_values($this->_values));
	}

	/**
	 * See `Map.keyValueIterator`
	 * 
	 * @return object
	 */
	public function keyValueIterator () {
		return new MapKeyValueIterator($this);
	}

	/**
	 * See `Map.keys`
	 * (cs, java) Implementation detail: Do not `set()` any new value while
	 * iterating, as it may cause a resize, which will break iteration.
	 * 
	 * @return object
	 */
	public function keys () {
		return new NativeIndexedArrayIterator(\array_values($this->_keys));
	}

	/**
	 * See `Map.remove`
	 * 
	 * @param mixed $key
	 * 
	 * @return bool
	 */
	public function remove ($key) {
		$id = \spl_object_hash($key);
		if (\array_key_exists($id, $this->_values)) {
			unset($this->_keys[$id], $this->_values[$id]);
			return true;
		} else {
			return false;
		}
	}

	/**
	 * See `Map.set`
	 * 
	 * @param mixed $key
	 * @param mixed $value
	 * 
	 * @return void
	 */
	public function set ($key, $value) {
		$id = \spl_object_hash($key);
		$this->_keys[$id] = $key;
		$this->_values[$id] = $value;
	}

	/**
	 * See `Map.toString`
	 * 
	 * @return string
	 */
	public function toString () {
		$s = "{";
		$it = new NativeIndexedArrayIterator(\array_values($this->_keys));
		while ($it->hasNext()) {
			$i = $it->next();
			$s = ($s??'null') . (\Std::string($i)??'null');
			$s = ($s??'null') . " => ";
			$s = ($s??'null') . (\Std::string($this->get($i))??'null');
			if ($it->hasNext()) {
				$s = ($s??'null') . ", ";
			}
		}
		return ($s??'null') . "}";
	}

	public function __toString() {
		return $this->toString();
	}
}

Boot::registerClass(ObjectMap::class, 'haxe.ds.ObjectMap');
