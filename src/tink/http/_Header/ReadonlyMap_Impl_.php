<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace tink\http\_Header;

use \php\Boot;
use \haxe\IMap;

final class ReadonlyMap_Impl_ {
	/**
	 * @param IMap $this
	 * @param mixed $key
	 * 
	 * @return bool
	 */
	public static function exists ($this1, $key) {
		return $this1->exists($key);
	}

	/**
	 * @param IMap $this
	 * @param mixed $key
	 * 
	 * @return mixed
	 */
	public static function get ($this1, $key) {
		return $this1->get($key);
	}

	/**
	 * @param IMap $this
	 * 
	 * @return object
	 */
	public static function iterator ($this1) {
		return $this1->iterator();
	}

	/**
	 * @param IMap $this
	 * 
	 * @return object
	 */
	public static function keys ($this1) {
		return $this1->keys();
	}
}

Boot::registerClass(ReadonlyMap_Impl_::class, 'tink.http._Header.ReadonlyMap_Impl_');
