<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace haxe\rtti;

use \php\_Boot\HxAnon;
use \php\Boot;
use \haxe\Exception;

/**
 * An API to access classes and enums metadata at runtime.
 * @see <https://haxe.org/manual/cr-rtti.html>
 */
class Meta {
	/**
	 * Returns the metadata that were declared for the given class fields or enum constructors
	 * 
	 * @param mixed $t
	 * 
	 * @return mixed
	 */
	public static function getFields ($t) {
		$meta = Meta::getMeta($t);
		if (($meta === null) || ($meta->fields === null)) {
			return new HxAnon();
		} else {
			return $meta->fields;
		}
	}

	/**
	 * @param mixed $t
	 * 
	 * @return object
	 */
	public static function getMeta ($t) {
		return Boot::getMeta(Boot::dynamicField($t, 'phpClassName'));
	}

	/**
	 * Returns the metadata that were declared for the given class static fields
	 * 
	 * @param mixed $t
	 * 
	 * @return mixed
	 */
	public static function getStatics ($t) {
		$meta = Meta::getMeta($t);
		if (($meta === null) || ($meta->statics === null)) {
			return new HxAnon();
		} else {
			return $meta->statics;
		}
	}

	/**
	 * Returns the metadata that were declared for the given type (class or enum)
	 * 
	 * @param mixed $t
	 * 
	 * @return mixed
	 */
	public static function getType ($t) {
		$meta = Meta::getMeta($t);
		if (($meta === null) || ($meta->obj === null)) {
			return new HxAnon();
		} else {
			return $meta->obj;
		}
	}

	/**
	 * @param mixed $t
	 * 
	 * @return bool
	 */
	public static function isInterface ($t) {
		throw Exception::thrown("Something went wrong");
	}
}

Boot::registerClass(Meta::class, 'haxe.rtti.Meta');
