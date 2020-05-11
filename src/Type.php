<?php
/**
 * Generated by Haxe 4.0.5
 */

use \php\_Boot\HxAnon;
use \php\Boot;
use \php\_Boot\HxClass;
use \haxe\CallStack;
use \php\_Boot\HxString;
use \php\_Boot\HxClosure;
use \php\_Boot\HxException;
use \php\_Boot\HxEnum;

/**
 * The Haxe Reflection API allows retrieval of type information at runtime.
 * This class complements the more lightweight Reflect class, with a focus on
 * class and enum instances.
 * @see https://haxe.org/manual/types.html
 * @see https://haxe.org/manual/std-reflection.html
 */
class Type {
	/**
	 * Returns a list of all constructors of enum `e` that require no
	 * arguments.
	 * This may return the empty Array `[]` if all constructors of `e` require
	 * arguments.
	 * Otherwise an instance of `e` constructed through each of its non-
	 * argument constructors is returned, in the order of the constructor
	 * declaration.
	 * If `e` is null, the result is unspecified.
	 * 
	 * @param Enum $e
	 * 
	 * @return \Array_hx
	 */
	public static function allEnums ($e) {
		if ($e === null) {
			return null;
		}
		$phpName = $e->phpClassName;
		$result = new \Array_hx();
		$_g = 0;
		$_g1 = Type::getEnumConstructs($e);
		while ($_g < $_g1->length) {
			$name = ($_g1->arr[$_g] ?? null);
			++$_g;
			$reflection = new \ReflectionMethod($phpName, $name);
			if ($reflection->getNumberOfParameters() === 0) {
				$x = $reflection->invoke(null);
				$result->arr[$result->length] = $x;
				++$result->length;
			}
		}

		return $result;
	}

	/**
	 * Creates an instance of class `cl`.
	 * This function guarantees that the class constructor is not called.
	 * If `cl` is null, the result is unspecified.
	 * 
	 * @param Class $cl
	 * 
	 * @return mixed
	 */
	public static function createEmptyInstance ($cl) {
		if (Boot::getClass('String') === $cl) {
			return "";
		}
		if (Boot::getClass(\Array_hx::class) === $cl) {
			return new \Array_hx();
		}
		$reflection = new \ReflectionClass($cl->phpClassName);
		return $reflection->newInstanceWithoutConstructor();
	}

	/**
	 * Creates an instance of enum `e` by calling its constructor `constr` with
	 * arguments `params`.
	 * If `e` or `constr` is null, or if enum `e` has no constructor named
	 * `constr`, or if the number of elements in `params` does not match the
	 * expected number of constructor arguments, or if any argument has an
	 * invalid type, the result is unspecified.
	 * 
	 * @param Enum $e
	 * @param string $constr
	 * @param \Array_hx $params
	 * 
	 * @return mixed
	 */
	public static function createEnum ($e, $constr, $params = null) {
		if (($e === null) || ($constr === null)) {
			return null;
		}
		$phpName = $e->phpClassName;
		$tmp = $phpName;
		if (!in_array($constr, $tmp::{"__hx__list"}())) {
			throw new HxException("No such constructor " . ($constr??'null'));
		}
		$tmp1 = $phpName;
		$paramsCounts = $tmp1::{"__hx__paramsCount"}();
		if ((($params === null) && ($paramsCounts[$constr] !== 0)) || (($params !== null) && ($params->length !== $paramsCounts[$constr]))) {
			throw new HxException("Provided parameters count does not match expected parameters count");
		}
		if ($params === null) {
			$tmp2 = $phpName;
			return $tmp2::{$constr}();
		} else {
			$nativeArgs = $params->arr;
			$tmp3 = $phpName;
			return $tmp3::{$constr}(...$nativeArgs);
		}
	}

	/**
	 * Creates an instance of enum `e` by calling its constructor number
	 * `index` with arguments `params`.
	 * The constructor indices are preserved from Haxe syntax, so the first
	 * declared is index 0, the next index 1 etc.
	 * If `e` or `constr` is null, or if enum `e` has no constructor named
	 * `constr`, or if the number of elements in `params` does not match the
	 * expected number of constructor arguments, or if any argument has an
	 * invalid type, the result is unspecified.
	 * 
	 * @param Enum $e
	 * @param int $index
	 * @param \Array_hx $params
	 * 
	 * @return mixed
	 */
	public static function createEnumIndex ($e, $index, $params = null) {
		if (($e === null) || ($index === null)) {
			return null;
		}
		$phpName = $e->phpClassName;
		$tmp = $phpName;
		$constructors = $tmp::{"__hx__list"}();
		if (($index < 0) || ($index >= count($constructors))) {
			throw new HxException("" . ($index??'null') . " is not a valid enum constructor index");
		}
		$constr = $constructors[$index];
		$tmp1 = $phpName;
		$paramsCounts = $tmp1::{"__hx__paramsCount"}();
		if ((($params === null) && ($paramsCounts[$constr] !== 0)) || (($params !== null) && ($params->length !== $paramsCounts[$constr]))) {
			throw new HxException("Provided parameters count does not match expected parameters count");
		}
		if ($params === null) {
			$tmp2 = $phpName;
			return $tmp2::{$constr}();
		} else {
			$nativeArgs = $params->arr;
			$tmp3 = $phpName;
			return $tmp3::{$constr}(...$nativeArgs);
		}
	}

	/**
	 * Creates an instance of class `cl`, using `args` as arguments to the
	 * class constructor.
	 * This function guarantees that the class constructor is called.
	 * Default values of constructors arguments are not guaranteed to be
	 * taken into account.
	 * If `cl` or `args` are null, or if the number of elements in `args` does
	 * not match the expected number of constructor arguments, or if any
	 * argument has an invalid type,  or if `cl` has no own constructor, the
	 * result is unspecified.
	 * In particular, default values of constructor arguments are not
	 * guaranteed to be taken into account.
	 * 
	 * @param Class $cl
	 * @param \Array_hx $args
	 * 
	 * @return mixed
	 */
	public static function createInstance ($cl, $args) {
		if (Boot::getClass('String') === $cl) {
			return ($args->arr[0] ?? null);
		}
		$nativeArgs = $args->arr;
		$tmp = $cl->phpClassName;
		return new $tmp(...$nativeArgs);
	}

	/**
	 * Returns the constructor name of enum instance `e`.
	 * The result String does not contain any constructor arguments.
	 * If `e` is null, the result is unspecified.
	 * 
	 * @param mixed $e
	 * 
	 * @return string
	 */
	public static function enumConstructor ($e) {
		return $e->tag;
	}

	/**
	 * Recursively compares two enum instances `a` and `b` by value.
	 * Unlike `a == b`, this function performs a deep equality check on the
	 * arguments of the constructors, if exists.
	 * If `a` or `b` are null, the result is unspecified.
	 * 
	 * @param mixed $a
	 * @param mixed $b
	 * 
	 * @return bool
	 */
	public static function enumEq ($a, $b) {
		if (($a === $b)) {
			return true;
		}
		if (($a === null) || ($b === null)) {
			return false;
		}
		try {
			$tmp = $a;
			$tmp1 = get_class($b);
			if (!($tmp instanceof $tmp1)) {
				return false;
			}
			if ($a->index !== $b->index) {
				return false;
			}
			$aParams = $a->params;
			$bParams = $b->params;
			$_g = 0;
			$_g1 = count($aParams);
			while ($_g < $_g1) {
				$i = $_g++;
				if (($aParams[$i] instanceof HxEnum)) {
					if (!Type::enumEq($aParams[$i], $bParams[$i])) {
						return false;
					}
				} else {
					$left = $aParams[$i];
					$right = $bParams[$i];
					if (!(((is_int($left) || is_float($left)) && (is_int($right) || is_float($right)) ? ($left == $right) : (($left instanceof HxClosure) && ($right instanceof HxClosure) ? $left->equals($right) : ($left === $right))))) {
						return false;
					}
				}
			}

			return true;
		} catch (\Throwable $__hx__caught_e) {
			CallStack::saveExceptionTrace($__hx__caught_e);
			$__hx__real_e = ($__hx__caught_e instanceof HxException ? $__hx__caught_e->e : $__hx__caught_e);
			$e = $__hx__real_e;
			return false;
		}
	}

	/**
	 * Returns the index of enum instance `e`.
	 * This corresponds to the original syntactic position of `e`. The index of
	 * the first declared constructor is 0, the next one is 1 etc.
	 * If `e` is null, the result is unspecified.
	 * 
	 * @param mixed $e
	 * 
	 * @return int
	 */
	public static function enumIndex ($e) {
		return $e->index;
	}

	/**
	 * Returns a list of the constructor arguments of enum instance `e`.
	 * If `e` has no arguments, the result is [].
	 * Otherwise the result are the values that were used as arguments to `e`,
	 * in the order of their declaration.
	 * If `e` is null, the result is unspecified.
	 * 
	 * @param mixed $e
	 * 
	 * @return \Array_hx
	 */
	public static function enumParameters ($e) {
		return \Array_hx::wrap($e->params);
	}

	/**
	 * Returns the class of `o`, if `o` is a class instance.
	 * If `o` is null or of a different type, null is returned.
	 * In general, type parameter information cannot be obtained at runtime.
	 * 
	 * @param mixed $o
	 * 
	 * @return Class
	 */
	public static function getClass ($o) {
		if (is_object($o) && !($o instanceof HxClass) && !($o instanceof HxEnum)) {
			$cls = Boot::getClass(get_class($o));
			if ($cls === Boot::getClass(HxAnon::class)) {
				return null;
			} else {
				return $cls;
			}
		} else if (is_string($o)) {
			return Boot::getClass('String');
		} else {
			return null;
		}
	}

	/**
	 * Returns a list of static fields of class `c`.
	 * This does not include static fields of parent classes.
	 * The order of the fields in the returned Array is unspecified.
	 * If `c` is null, the result is unspecified.
	 * (As3) This method only returns class fields that are public.
	 * 
	 * @param Class $c
	 * 
	 * @return \Array_hx
	 */
	public static function getClassFields ($c) {
		if ($c === null) {
			return null;
		}
		if ($c === Boot::getClass('String')) {
			return \Array_hx::wrap(["fromCharCode"]);
		}
		$phpName = $c->phpClassName;
		$reflection = new \ReflectionClass($phpName);
		$this1 = [];
		$methods = $this1;
		$data = $reflection->getMethods(\ReflectionMethod::IS_STATIC);
		$_g_current = 0;
		$_g_length = count($data);
		$_g_data = $data;
		while ($_g_current < $_g_length) {
			$m = $_g_data[$_g_current++];
			$name = $m->getName();
			if (!(($name === "__construct") || (HxString::indexOf($name, "__hx_") === 0)) && ($phpName === $m->getDeclaringClass()->getName())) {
				array_push($methods, $name);
			}
		}

		$this2 = [];
		$properties = $this2;
		$data1 = $reflection->getProperties(\ReflectionProperty::IS_STATIC);
		$_g1_current = 0;
		$_g1_length = count($data1);
		$_g1_data = $data1;
		while ($_g1_current < $_g1_length) {
			$p = $_g1_data[$_g1_current++];
			$name1 = $p->getName();
			if (!(($name1 === "__construct") || (HxString::indexOf($name1, "__hx_") === 0)) && ($phpName === $p->getDeclaringClass()->getName())) {
				array_push($properties, $name1);
			}
		}

		$properties = array_diff($properties, $methods);
		$fields = array_merge($properties, $methods);
		return \Array_hx::wrap($fields);
	}

	/**
	 * Returns the name of class `c`, including its path.
	 * If `c` is inside a package, the package structure is returned dot-
	 * separated, with another dot separating the class name:
	 * `pack1.pack2.(...).packN.ClassName`
	 * If `c` is a sub-type of a Haxe module, that module is not part of the
	 * package structure.
	 * If `c` has no package, the class name is returned.
	 * If `c` is null, the result is unspecified.
	 * The class name does not include any type parameters.
	 * 
	 * @param Class $c
	 * 
	 * @return string
	 */
	public static function getClassName ($c) {
		if ($c === null) {
			return null;
		}
		return Boot::getHaxeName($c);
	}

	/**
	 * Returns the enum of enum instance `o`.
	 * An enum instance is the result of using an enum constructor. Given an
	 * `enum Color { Red; }`, `getEnum(Red)` returns `Enum<Color>`.
	 * If `o` is null, null is returned.
	 * In general, type parameter information cannot be obtained at runtime.
	 * 
	 * @param mixed $o
	 * 
	 * @return Enum
	 */
	public static function getEnum ($o) {
		if ($o === null) {
			return null;
		}
		return Boot::getClass(get_class($o));
	}

	/**
	 * Returns a list of the names of all constructors of enum `e`.
	 * The order of the constructor names in the returned Array is preserved
	 * from the original syntax.
	 * If `e` is null, the result is unspecified.
	 * 
	 * @param Enum $e
	 * 
	 * @return \Array_hx
	 */
	public static function getEnumConstructs ($e) {
		if ($e === null) {
			return null;
		}
		$tmp = $e;
		return \Array_hx::wrap($tmp->{"__hx__list"}());
	}

	/**
	 * Returns the name of enum `e`, including its path.
	 * If `e` is inside a package, the package structure is returned dot-
	 * separated, with another dot separating the enum name:
	 * `pack1.pack2.(...).packN.EnumName`
	 * If `e` is a sub-type of a Haxe module, that module is not part of the
	 * package structure.
	 * If `e` has no package, the enum name is returned.
	 * If `e` is null, the result is unspecified.
	 * The enum name does not include any type parameters.
	 * 
	 * @param Enum $e
	 * 
	 * @return string
	 */
	public static function getEnumName ($e) {
		return Type::getClassName($e);
	}

	/**
	 * Returns a list of the instance fields of class `c`, including
	 * inherited fields.
	 * This only includes fields which are known at compile-time. In
	 * particular, using `getInstanceFields(getClass(obj))` will not include
	 * any fields which were added to `obj` at runtime.
	 * The order of the fields in the returned Array is unspecified.
	 * If `c` is null, the result is unspecified.
	 * (As3) This method only returns instance fields that are public.
	 * 
	 * @param Class $c
	 * 
	 * @return \Array_hx
	 */
	public static function getInstanceFields ($c) {
		if ($c === null) {
			return null;
		}
		if ($c === Boot::getClass('String')) {
			return \Array_hx::wrap([
				"substr",
				"charAt",
				"charCodeAt",
				"indexOf",
				"lastIndexOf",
				"split",
				"toLowerCase",
				"toUpperCase",
				"toString",
				"length",
			]);
		}
		$reflection = new \ReflectionClass($c->phpClassName);
		$this1 = [];
		$methods = $this1;
		$data = $reflection->getMethods();
		$_g_current = 0;
		$_g_length = count($data);
		$_g_data = $data;
		while ($_g_current < $_g_length) {
			$method = $_g_data[$_g_current++];
			if (!$method->isStatic()) {
				$name = $method->getName();
				if (!(($name === "__construct") || (HxString::indexOf($name, "__hx_") === 0))) {
					array_push($methods, $name);
				}
			}
		}

		$this2 = [];
		$properties = $this2;
		$data1 = $reflection->getProperties();
		$_g1_current = 0;
		$_g1_length = count($data1);
		$_g1_data = $data1;
		while ($_g1_current < $_g1_length) {
			$property = $_g1_data[$_g1_current++];
			if (!$property->isStatic()) {
				$name1 = $property->getName();
				if (!(($name1 === "__construct") || (HxString::indexOf($name1, "__hx_") === 0))) {
					array_push($properties, $name1);
				}
			}
		}

		$properties = array_diff($properties, $methods);
		$fields = array_merge($properties, $methods);
		return \Array_hx::wrap($fields);
	}

	/**
	 * Returns the super-class of class `c`.
	 * If `c` has no super class, null is returned.
	 * If `c` is null, the result is unspecified.
	 * In general, type parameter information cannot be obtained at runtime.
	 * 
	 * @param Class $c
	 * 
	 * @return Class
	 */
	public static function getSuperClass ($c) {
		if ($c === null) {
			return null;
		}
		$parentClass = get_parent_class($c->phpClassName);
		if (!$parentClass) {
			return null;
		}
		return Boot::getClass($parentClass);
	}

	/**
	 * check if specified `name` is a special field name generated by compiler.
	 * 
	 * @param string $name
	 * 
	 * @return bool
	 */
	public static function isServiceFieldName ($name) {
		if ($name !== "__construct") {
			return HxString::indexOf($name, "__hx_") === 0;
		} else {
			return true;
		}
	}

	/**
	 * Resolves a class by name.
	 * If `name` is the path of an existing class, that class is returned.
	 * Otherwise null is returned.
	 * If `name` is null or the path to a different type, the result is
	 * unspecified.
	 * The class name must not include any type parameters.
	 * 
	 * @param string $name
	 * 
	 * @return Class
	 */
	public static function resolveClass ($name) {
		if ($name === null) {
			return null;
		}
		if ($name === "Bool") {
			return Boot::getClass('Bool');
		} else if ($name === "Class") {
			return Boot::getClass('Class');
		} else if ($name === "Dynamic") {
			return Boot::getClass('Dynamic');
		} else if ($name === "Enum") {
			return Boot::getClass('Enum');
		} else if ($name === "Float") {
			return Boot::getClass('Float');
		} else if ($name === "Int") {
			return Boot::getClass('Int');
		} else if ($name === "String") {
			return Boot::getClass('String');
		}
		$phpClass = Boot::getPhpName($name);
		if (!class_exists($phpClass) && !interface_exists($phpClass)) {
			return null;
		}
		$hxClass = Boot::getClass($phpClass);
		return $hxClass;
	}

	/**
	 * Resolves an enum by name.
	 * If `name` is the path of an existing enum, that enum is returned.
	 * Otherwise null is returned.
	 * If `name` is null the result is unspecified.
	 * If `name` is the path to a different type, null is returned.
	 * The enum name must not include any type parameters.
	 * 
	 * @param string $name
	 * 
	 * @return Enum
	 */
	public static function resolveEnum ($name) {
		if ($name === null) {
			return null;
		}
		if ($name === "Bool") {
			return Boot::getClass('Bool');
		}
		$phpClass = Boot::getPhpName($name);
		if (!class_exists($phpClass)) {
			return null;
		}
		$hxClass = Boot::getClass($phpClass);
		return $hxClass;
	}

	/**
	 * Returns the runtime type of value `v`.
	 * The result corresponds to the type `v` has at runtime, which may vary
	 * per platform. Assumptions regarding this should be minimized to avoid
	 * surprises.
	 * 
	 * @param mixed $v
	 * 
	 * @return \ValueType
	 */
	public static function typeof ($v) {
		if ($v === null) {
			return \ValueType::TNull();
		}
		if (is_object($v)) {
			if (($v instanceof \Closure) || ($v instanceof HxClosure)) {
				return \ValueType::TFunction();
			}
			if (($v instanceof \StdClass)) {
				return \ValueType::TObject();
			}
			if (($v instanceof HxClass)) {
				return \ValueType::TObject();
			}
			$hxClass = Boot::getClass(get_class($v));
			if (($v instanceof HxEnum)) {
				return \ValueType::TEnum($hxClass);
			}
			return \ValueType::TClass($hxClass);
		}
		if (is_bool($v)) {
			return \ValueType::TBool();
		}
		if (is_int($v)) {
			return \ValueType::TInt();
		}
		if (is_float($v)) {
			return \ValueType::TFloat();
		}
		if (is_string($v)) {
			return \ValueType::TClass(Boot::getClass('String'));
		}
		return \ValueType::TUnknown();
	}
}

Boot::registerClass(Type::class, 'Type');
