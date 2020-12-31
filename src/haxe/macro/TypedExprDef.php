<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace haxe\macro;

use \php\Boot;
use \php\_Boot\HxEnum;

/**
 * Represents kind of a node in the typed AST.
 */
class TypedExprDef extends HxEnum {
	/**
	 * Array access `e1[e2]`.
	 * 
	 * @param object $e1
	 * @param object $e2
	 * 
	 * @return TypedExprDef
	 */
	static public function TArray ($e1, $e2) {
		return new TypedExprDef('TArray', 2, [$e1, $e2]);
	}

	/**
	 * An array declaration `[el]`.
	 * 
	 * @param \Array_hx $el
	 * 
	 * @return TypedExprDef
	 */
	static public function TArrayDecl ($el) {
		return new TypedExprDef('TArrayDecl', 8, [$el]);
	}

	/**
	 * Binary operator `e1 op e2`.
	 * 
	 * @param Binop $op
	 * @param object $e1
	 * @param object $e2
	 * 
	 * @return TypedExprDef
	 */
	static public function TBinop ($op, $e1, $e2) {
		return new TypedExprDef('TBinop', 3, [$op, $e1, $e2]);
	}

	/**
	 * A block declaration `{el}`.
	 * 
	 * @param \Array_hx $el
	 * 
	 * @return TypedExprDef
	 */
	static public function TBlock ($el) {
		return new TypedExprDef('TBlock', 14, [$el]);
	}

	/**
	 * A `break` expression.
	 * 
	 * @return TypedExprDef
	 */
	static public function TBreak () {
		static $inst = null;
		if (!$inst) $inst = new TypedExprDef('TBreak', 21, []);
		return $inst;
	}

	/**
	 * A call `e(el)`.
	 * 
	 * @param object $e
	 * @param \Array_hx $el
	 * 
	 * @return TypedExprDef
	 */
	static public function TCall ($e, $el) {
		return new TypedExprDef('TCall', 9, [$e, $el]);
	}

	/**
	 * A `cast e` or `cast (e, m)` expression.
	 * 
	 * @param object $e
	 * @param ModuleType $m
	 * 
	 * @return TypedExprDef
	 */
	static public function TCast ($e, $m) {
		return new TypedExprDef('TCast', 24, [$e, $m]);
	}

	/**
	 * A constant.
	 * 
	 * @param TConstant $c
	 * 
	 * @return TypedExprDef
	 */
	static public function TConst ($c) {
		return new TypedExprDef('TConst', 0, [$c]);
	}

	/**
	 * A `continue` expression.
	 * 
	 * @return TypedExprDef
	 */
	static public function TContinue () {
		static $inst = null;
		if (!$inst) $inst = new TypedExprDef('TContinue', 22, []);
		return $inst;
	}

	/**
	 * Access to an enum index (generated by the pattern matcher).
	 * 
	 * @param object $e1
	 * 
	 * @return TypedExprDef
	 */
	static public function TEnumIndex ($e1) {
		return new TypedExprDef('TEnumIndex', 27, [$e1]);
	}

	/**
	 * Access to an enum parameter (generated by the pattern matcher).
	 * 
	 * @param object $e1
	 * @param object $ef
	 * @param int $index
	 * 
	 * @return TypedExprDef
	 */
	static public function TEnumParameter ($e1, $ef, $index) {
		return new TypedExprDef('TEnumParameter', 26, [$e1, $ef, $index]);
	}

	/**
	 * Field access on `e` according to `fa`.
	 * 
	 * @param object $e
	 * @param FieldAccess $fa
	 * 
	 * @return TypedExprDef
	 */
	static public function TField ($e, $fa) {
		return new TypedExprDef('TField', 4, [$e, $fa]);
	}

	/**
	 * A `for` expression.
	 * 
	 * @param object $v
	 * @param object $e1
	 * @param object $e2
	 * 
	 * @return TypedExprDef
	 */
	static public function TFor ($v, $e1, $e2) {
		return new TypedExprDef('TFor', 15, [$v, $e1, $e2]);
	}

	/**
	 * A function declaration.
	 * 
	 * @param object $tfunc
	 * 
	 * @return TypedExprDef
	 */
	static public function TFunction ($tfunc) {
		return new TypedExprDef('TFunction', 12, [$tfunc]);
	}

	/**
	 * An unknown identifier.
	 * 
	 * @param string $s
	 * 
	 * @return TypedExprDef
	 */
	static public function TIdent ($s) {
		return new TypedExprDef('TIdent', 28, [$s]);
	}

	/**
	 * An `if(econd) eif` or `if(econd) eif else eelse` expression.
	 * 
	 * @param object $econd
	 * @param object $eif
	 * @param object $eelse
	 * 
	 * @return TypedExprDef
	 */
	static public function TIf ($econd, $eif, $eelse) {
		return new TypedExprDef('TIf', 16, [$econd, $eif, $eelse]);
	}

	/**
	 * Reference to a local variable `v`.
	 * 
	 * @param object $v
	 * 
	 * @return TypedExprDef
	 */
	static public function TLocal ($v) {
		return new TypedExprDef('TLocal', 1, [$v]);
	}

	/**
	 * A `@m e1` expression.
	 * 
	 * @param object $m
	 * @param object $e1
	 * 
	 * @return TypedExprDef
	 */
	static public function TMeta ($m, $e1) {
		return new TypedExprDef('TMeta', 25, [$m, $e1]);
	}

	/**
	 * A constructor call `new c<params>(el)`.
	 * 
	 * @param object $c
	 * @param \Array_hx $params
	 * @param \Array_hx $el
	 * 
	 * @return TypedExprDef
	 */
	static public function TNew ($c, $params, $el) {
		return new TypedExprDef('TNew', 10, [$c, $params, $el]);
	}

	/**
	 * An object declaration.
	 * 
	 * @param \Array_hx $fields
	 * 
	 * @return TypedExprDef
	 */
	static public function TObjectDecl ($fields) {
		return new TypedExprDef('TObjectDecl', 7, [$fields]);
	}

	/**
	 * Parentheses `(e)`.
	 * 
	 * @param object $e
	 * 
	 * @return TypedExprDef
	 */
	static public function TParenthesis ($e) {
		return new TypedExprDef('TParenthesis', 6, [$e]);
	}

	/**
	 * A `return` or `return e` expression.
	 * 
	 * @param object $e
	 * 
	 * @return TypedExprDef
	 */
	static public function TReturn ($e) {
		return new TypedExprDef('TReturn', 20, [$e]);
	}

	/**
	 * Represents a `switch` expression with related cases and an optional
	 * `default` case if edef != null.
	 * 
	 * @param object $e
	 * @param \Array_hx $cases
	 * @param object $edef
	 * 
	 * @return TypedExprDef
	 */
	static public function TSwitch ($e, $cases, $edef) {
		return new TypedExprDef('TSwitch', 18, [$e, $cases, $edef]);
	}

	/**
	 * A `throw e` expression.
	 * 
	 * @param object $e
	 * 
	 * @return TypedExprDef
	 */
	static public function TThrow ($e) {
		return new TypedExprDef('TThrow', 23, [$e]);
	}

	/**
	 * Represents a `try`-expression with related catches.
	 * 
	 * @param object $e
	 * @param \Array_hx $catches
	 * 
	 * @return TypedExprDef
	 */
	static public function TTry ($e, $catches) {
		return new TypedExprDef('TTry', 19, [$e, $catches]);
	}

	/**
	 * Reference to a module type `m`.
	 * 
	 * @param ModuleType $m
	 * 
	 * @return TypedExprDef
	 */
	static public function TTypeExpr ($m) {
		return new TypedExprDef('TTypeExpr', 5, [$m]);
	}

	/**
	 * An unary operator `op` on `e`:
	 * e++ (op = OpIncrement, postFix = true)
	 * e-- (op = OpDecrement, postFix = true)
	 * ++e (op = OpIncrement, postFix = false)
	 * --e (op = OpDecrement, postFix = false)
	 * -e (op = OpNeg, postFix = false)
	 * !e (op = OpNot, postFix = false)
	 * ~e (op = OpNegBits, postFix = false)
	 * 
	 * @param Unop $op
	 * @param bool $postFix
	 * @param object $e
	 * 
	 * @return TypedExprDef
	 */
	static public function TUnop ($op, $postFix, $e) {
		return new TypedExprDef('TUnop', 11, [$op, $postFix, $e]);
	}

	/**
	 * A variable declaration `var v` or `var v = expr`.
	 * 
	 * @param object $v
	 * @param object $expr
	 * 
	 * @return TypedExprDef
	 */
	static public function TVar ($v, $expr) {
		return new TypedExprDef('TVar', 13, [$v, $expr]);
	}

	/**
	 * Represents a `while` expression.
	 * When `normalWhile` is `true` it is `while (...)`.
	 * When `normalWhile` is `false` it is `do {...} while (...)`.
	 * 
	 * @param object $econd
	 * @param object $e
	 * @param bool $normalWhile
	 * 
	 * @return TypedExprDef
	 */
	static public function TWhile ($econd, $e, $normalWhile) {
		return new TypedExprDef('TWhile', 17, [$econd, $e, $normalWhile]);
	}

	/**
	 * Returns array of (constructorIndex => constructorName)
	 *
	 * @return string[]
	 */
	static public function __hx__list () {
		return [
			2 => 'TArray',
			8 => 'TArrayDecl',
			3 => 'TBinop',
			14 => 'TBlock',
			21 => 'TBreak',
			9 => 'TCall',
			24 => 'TCast',
			0 => 'TConst',
			22 => 'TContinue',
			27 => 'TEnumIndex',
			26 => 'TEnumParameter',
			4 => 'TField',
			15 => 'TFor',
			12 => 'TFunction',
			28 => 'TIdent',
			16 => 'TIf',
			1 => 'TLocal',
			25 => 'TMeta',
			10 => 'TNew',
			7 => 'TObjectDecl',
			6 => 'TParenthesis',
			20 => 'TReturn',
			18 => 'TSwitch',
			23 => 'TThrow',
			19 => 'TTry',
			5 => 'TTypeExpr',
			11 => 'TUnop',
			13 => 'TVar',
			17 => 'TWhile',
		];
	}

	/**
	 * Returns array of (constructorName => parametersCount)
	 *
	 * @return int[]
	 */
	static public function __hx__paramsCount () {
		return [
			'TArray' => 2,
			'TArrayDecl' => 1,
			'TBinop' => 3,
			'TBlock' => 1,
			'TBreak' => 0,
			'TCall' => 2,
			'TCast' => 2,
			'TConst' => 1,
			'TContinue' => 0,
			'TEnumIndex' => 1,
			'TEnumParameter' => 3,
			'TField' => 2,
			'TFor' => 3,
			'TFunction' => 1,
			'TIdent' => 1,
			'TIf' => 3,
			'TLocal' => 1,
			'TMeta' => 2,
			'TNew' => 3,
			'TObjectDecl' => 1,
			'TParenthesis' => 1,
			'TReturn' => 1,
			'TSwitch' => 3,
			'TThrow' => 1,
			'TTry' => 2,
			'TTypeExpr' => 1,
			'TUnop' => 3,
			'TVar' => 2,
			'TWhile' => 3,
		];
	}
}

Boot::registerClass(TypedExprDef::class, 'haxe.macro.TypedExprDef');
