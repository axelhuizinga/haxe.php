<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace haxe\xml\_Access;

use \php\Boot;
use \haxe\Exception;

final class HasAttribAccess_Impl_ {
	/**
	 * @param \Xml $this
	 * @param string $name
	 * 
	 * @return bool
	 */
	public static function resolve ($this1, $name) {
		if ($this1->nodeType === \Xml::$Document) {
			throw Exception::thrown("Cannot access document attribute " . ($name??'null'));
		}
		return $this1->exists($name);
	}
}

Boot::registerClass(HasAttribAccess_Impl_::class, 'haxe.xml._Access.HasAttribAccess_Impl_');
