<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace haxe\_Template;

use \php\Boot;
use \haxe\ds\List_hx;
use \php\_Boot\HxEnum;

class TemplateExpr extends HxEnum {
	/**
	 * @param List_hx $l
	 * 
	 * @return TemplateExpr
	 */
	static public function OpBlock ($l) {
		return new TemplateExpr('OpBlock', 4, [$l]);
	}

	/**
	 * @param \Closure $expr
	 * 
	 * @return TemplateExpr
	 */
	static public function OpExpr ($expr) {
		return new TemplateExpr('OpExpr', 1, [$expr]);
	}

	/**
	 * @param \Closure $expr
	 * @param TemplateExpr $loop
	 * 
	 * @return TemplateExpr
	 */
	static public function OpForeach ($expr, $loop) {
		return new TemplateExpr('OpForeach', 5, [$expr, $loop]);
	}

	/**
	 * @param \Closure $expr
	 * @param TemplateExpr $eif
	 * @param TemplateExpr $eelse
	 * 
	 * @return TemplateExpr
	 */
	static public function OpIf ($expr, $eif, $eelse) {
		return new TemplateExpr('OpIf', 2, [$expr, $eif, $eelse]);
	}

	/**
	 * @param string $name
	 * @param List_hx $params
	 * 
	 * @return TemplateExpr
	 */
	static public function OpMacro ($name, $params) {
		return new TemplateExpr('OpMacro', 6, [$name, $params]);
	}

	/**
	 * @param string $str
	 * 
	 * @return TemplateExpr
	 */
	static public function OpStr ($str) {
		return new TemplateExpr('OpStr', 3, [$str]);
	}

	/**
	 * @param string $v
	 * 
	 * @return TemplateExpr
	 */
	static public function OpVar ($v) {
		return new TemplateExpr('OpVar', 0, [$v]);
	}

	/**
	 * Returns array of (constructorIndex => constructorName)
	 *
	 * @return string[]
	 */
	static public function __hx__list () {
		return [
			4 => 'OpBlock',
			1 => 'OpExpr',
			5 => 'OpForeach',
			2 => 'OpIf',
			6 => 'OpMacro',
			3 => 'OpStr',
			0 => 'OpVar',
		];
	}

	/**
	 * Returns array of (constructorName => parametersCount)
	 *
	 * @return int[]
	 */
	static public function __hx__paramsCount () {
		return [
			'OpBlock' => 1,
			'OpExpr' => 1,
			'OpForeach' => 2,
			'OpIf' => 3,
			'OpMacro' => 2,
			'OpStr' => 1,
			'OpVar' => 1,
		];
	}
}

Boot::registerClass(TemplateExpr::class, 'haxe._Template.TemplateExpr');
