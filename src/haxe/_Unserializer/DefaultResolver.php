<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace haxe\_Unserializer;

use \php\Boot;

class DefaultResolver {
	/**
	 * @return void
	 */
	public function __construct () {
	}

	/**
	 * @param string $name
	 * 
	 * @return Class
	 */
	public function resolveClass ($name) {
		return \Type::resolveClass($name);
	}

	/**
	 * @param string $name
	 * 
	 * @return Enum
	 */
	public function resolveEnum ($name) {
		return \Type::resolveEnum($name);
	}
}

Boot::registerClass(DefaultResolver::class, 'haxe._Unserializer.DefaultResolver');
