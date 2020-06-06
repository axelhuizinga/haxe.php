<?php
/**
 * Generated by Haxe 4.1.1
 */

namespace haxe\macro;

use \php\Boot;
use \php\_Boot\HxEnum;

/**
 * Represents function kind in the AST
 */
class FunctionKind extends HxEnum {
	/**
	 * Anonymous function
	 * 
	 * @return FunctionKind
	 */
	static public function FAnonymous () {
		static $inst = null;
		if (!$inst) $inst = new FunctionKind('FAnonymous', 0, []);
		return $inst;
	}

	/**
	 * Arrow function
	 * 
	 * @return FunctionKind
	 */
	static public function FArrow () {
		static $inst = null;
		if (!$inst) $inst = new FunctionKind('FArrow', 2, []);
		return $inst;
	}

	/**
	 * Named function
	 * 
	 * @param string $name
	 * @param bool $inlined
	 * 
	 * @return FunctionKind
	 */
	static public function FNamed ($name, $inlined = null) {
		return new FunctionKind('FNamed', 1, [$name, $inlined]);
	}

	/**
	 * Returns array of (constructorIndex => constructorName)
	 *
	 * @return string[]
	 */
	static public function __hx__list () {
		return [
			0 => 'FAnonymous',
			2 => 'FArrow',
			1 => 'FNamed',
		];
	}

	/**
	 * Returns array of (constructorName => parametersCount)
	 *
	 * @return int[]
	 */
	static public function __hx__paramsCount () {
		return [
			'FAnonymous' => 0,
			'FArrow' => 0,
			'FNamed' => 2,
		];
	}
}

Boot::registerClass(FunctionKind::class, 'haxe.macro.FunctionKind');