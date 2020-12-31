<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace haxe\macro;

use \php\Boot;
use \php\_Boot\HxEnum;

/**
 * A unary operator.
 * @see https://haxe.org/manual/types-numeric-operators.html
 */
class Unop extends HxEnum {
	/**
	 * `--`
	 * 
	 * @return Unop
	 */
	static public function OpDecrement () {
		static $inst = null;
		if (!$inst) $inst = new Unop('OpDecrement', 1, []);
		return $inst;
	}

	/**
	 * `++`
	 * 
	 * @return Unop
	 */
	static public function OpIncrement () {
		static $inst = null;
		if (!$inst) $inst = new Unop('OpIncrement', 0, []);
		return $inst;
	}

	/**
	 * `-`
	 * 
	 * @return Unop
	 */
	static public function OpNeg () {
		static $inst = null;
		if (!$inst) $inst = new Unop('OpNeg', 3, []);
		return $inst;
	}

	/**
	 * `~`
	 * 
	 * @return Unop
	 */
	static public function OpNegBits () {
		static $inst = null;
		if (!$inst) $inst = new Unop('OpNegBits', 4, []);
		return $inst;
	}

	/**
	 * `!`
	 * 
	 * @return Unop
	 */
	static public function OpNot () {
		static $inst = null;
		if (!$inst) $inst = new Unop('OpNot', 2, []);
		return $inst;
	}

	/**
	 * Returns array of (constructorIndex => constructorName)
	 *
	 * @return string[]
	 */
	static public function __hx__list () {
		return [
			1 => 'OpDecrement',
			0 => 'OpIncrement',
			3 => 'OpNeg',
			4 => 'OpNegBits',
			2 => 'OpNot',
		];
	}

	/**
	 * Returns array of (constructorName => parametersCount)
	 *
	 * @return int[]
	 */
	static public function __hx__paramsCount () {
		return [
			'OpDecrement' => 0,
			'OpIncrement' => 0,
			'OpNeg' => 0,
			'OpNegBits' => 0,
			'OpNot' => 0,
		];
	}
}

Boot::registerClass(Unop::class, 'haxe.macro.Unop');
