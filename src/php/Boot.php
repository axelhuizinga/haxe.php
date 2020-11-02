<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace php;

use \php\_Boot\HxDynamicStr;
use \php\_Boot\HxAnon;
use \php\_Boot\HxClass;
use \haxe\Exception;
use \php\_Boot\HxString;
use \php\_Boot\HxClosure;
use \php\_Boot\HxEnum;

/**
 * Various Haxe->PHP compatibility utilities.
 * You should not use this class directly.
 */
class Boot {
	const PHP_PREFIX = "";

	/**
	 * @var mixed
	 * List of Haxe classes registered by their PHP class names
	 */
	static protected $aliases;
	/**
	 * @var mixed
	 * Cache of HxClass instances
	 */
	static protected $classes;
	/**
	 * @var mixed
	 * List of getters (for Reflect)
	 */
	static protected $getters;
	/**
	 * @var mixed
	 * Metadata storage
	 */
	static protected $meta;
	/**
	 * @var mixed
	 * List of setters (for Reflect)
	 */
	static protected $setters;
	/**
	 * @var mixed
	 * Cache for closures created of static methods
	 */
	static protected $staticClosures;

	/**
	 * Concat `left` and `right` if both are strings or string and null.
	 * Otherwise return sum of `left` and `right`.
	 * 
	 * @param mixed $left
	 * @param mixed $right
	 * 
	 * @return mixed
	 */
	public static function addOrConcat ($left, $right) {
		if (\is_string($left) || \is_string($right)) {
			return ($left??'null') . ($right??'null');
		}
		return ($left + $right);
	}

	/**
	 * Unsafe cast to HxClass
	 * 
	 * @param Class $cls
	 * 
	 * @return HxClass
	 */
	public static function castClass ($cls) {
		return $cls;
	}

	/**
	 * Unsafe cast to HxClosure
	 * 
	 * @param mixed $value
	 * 
	 * @return HxClosure
	 */
	public static function castClosure ($value) {
		return $value;
	}

	/**
	 * Unsafe cast to HxEnum
	 * 
	 * @param mixed $enm
	 * 
	 * @return HxEnum
	 */
	public static function castEnumValue ($enm) {
		return $enm;
	}

	/**
	 * Creates Haxe-compatible closure.
	 * @param type `this` for instance methods; full php class name for static methods
	 * @param func Method name
	 * 
	 * @param mixed $target
	 * @param string $func
	 * 
	 * @return HxClosure
	 */
	public static function closure ($target, $func) {
		if (\is_string($target)) {
			return Boot::getStaticClosure($target, $func);
		} else {
			return Boot::getInstanceClosure($target, $func);
		}
	}

	/**
	 * Returns `Class<T>` for `HxClosure`
	 * 
	 * @return HxClass
	 */
	public static function closureHxClass () {
		return Boot::getClass(HxClosure::class);
	}

	/**
	 * Create Haxe-compatible anonymous structure of `data` associative array
	 * 
	 * @param mixed $data
	 * 
	 * @return mixed
	 */
	public static function createAnon ($data) {
		return new HxAnon($data);
	}

	/**
	 * Helper method to avoid "Cannot use temporary expression in write context" error for expressions like this:
	 * ```haxe
	 * (new MyClass()).fieldName = 'value';
	 * ```
	 * 
	 * @param mixed $value
	 * 
	 * @return mixed
	 */
	public static function deref ($value) {
		return $value;
	}

	/**
	 * Get `field` of a dynamic `value` in a safe manner (avoid exceptions on trying to get a method)
	 * 
	 * @param mixed $value
	 * @param string $field
	 * 
	 * @return mixed
	 */
	public static function dynamicField ($value, $field) {
		if (\method_exists($value, $field)) {
			if (\is_string($value)) {
				return Boot::getStaticClosure($value, $field);
			} else {
				return Boot::getInstanceClosure($value, $field);
			}
		}
		if (\is_string($value)) {
			$value = new HxDynamicStr($value);
		}
		return $value->{$field};
	}

	/**
	 * @param string $str
	 * 
	 * @return HxDynamicStr
	 */
	public static function dynamicString ($str) {
		return new HxDynamicStr($str);
	}

	/**
	 * Make sure specified class is loaded
	 * 
	 * @param string $phpClassName
	 * 
	 * @return bool
	 */
	public static function ensureLoaded ($phpClassName) {
		if (!\class_exists($phpClassName)) {
			return \interface_exists($phpClassName);
		} else {
			return true;
		}
	}

	/**
	 * Check if specified values are equal
	 * 
	 * @param mixed $left
	 * @param mixed $right
	 * 
	 * @return bool
	 */
	public static function equal ($left, $right) {
		if ((\is_int($left) || \is_float($left)) && (\is_int($right) || \is_float($right))) {
			return ($left == $right);
		}
		if (($left instanceof HxClosure) && ($right instanceof HxClosure)) {
			return $left->equals($right);
		}
		return ($left === $right);
	}

	/**
	 * Get Class<T> instance for PHP fully qualified class name (E.g. '\some\pack\MyClass')
	 * It's always the same instance for the same `phpClassName`
	 * 
	 * @param string $phpClassName
	 * 
	 * @return HxClass
	 */
	public static function getClass ($phpClassName) {
		if (\mb_substr($phpClassName, 0, 1) === "\\") {
			$phpClassName = \mb_substr($phpClassName, 1, null);
		}
		if (!isset(Boot::$classes[$phpClassName])) {
			Boot::$classes[$phpClassName] = new HxClass($phpClassName);
		}
		return Boot::$classes[$phpClassName];
	}

	/**
	 * Returns either Haxe class name for specified `phpClassName` or (if no such Haxe class registered) `phpClassName`.
	 * 
	 * @param string $phpClassName
	 * 
	 * @return string
	 */
	public static function getClassName ($phpClassName) {
		$hxClass = Boot::getClass($phpClassName);
		$name = Boot::getHaxeName($hxClass);
		if ($name === null) {
			return $hxClass->phpClassName;
		} else {
			return $name;
		}
	}

	/**
	 * Returns original Haxe fully qualified class name for this type (if exists)
	 * 
	 * @param HxClass $hxClass
	 * 
	 * @return string
	 */
	public static function getHaxeName ($hxClass) {
		$__hx__switch = ($hxClass->phpClassName);
		if ($__hx__switch === "Bool") {
			return "Bool";
		} else if ($__hx__switch === "Class") {
			return "Class";
		} else if ($__hx__switch === "Dynamic") {
			return "Dynamic";
		} else if ($__hx__switch === "Enum") {
			return "Enum";
		} else if ($__hx__switch === "Float") {
			return "Float";
		} else if ($__hx__switch === "Int") {
			return "Int";
		} else if ($__hx__switch === "String") {
			return "String";
		} else {
		}
		if (isset(Boot::$aliases[$hxClass->phpClassName])) {
			return Boot::$aliases[$hxClass->phpClassName];
		} else if (\class_exists($hxClass->phpClassName) && isset(Boot::$aliases[$hxClass->phpClassName])) {
			return Boot::$aliases[$hxClass->phpClassName];
		} else if (\interface_exists($hxClass->phpClassName) && isset(Boot::$aliases[$hxClass->phpClassName])) {
			return Boot::$aliases[$hxClass->phpClassName];
		}
		return null;
	}

	/**
	 * Returns Class<HxAnon>
	 * 
	 * @return HxClass
	 */
	public static function getHxAnon () {
		return Boot::getClass(HxAnon::class);
	}

	/**
	 * Returns Class<HxClass>
	 * 
	 * @return HxClass
	 */
	public static function getHxClass () {
		return Boot::getClass(HxClass::class);
	}

	/**
	 * Creates Haxe-compatible closure of an instance method.
	 * @param obj - any object
	 * 
	 * @param object $obj
	 * @param string $methodName
	 * 
	 * @return HxClosure
	 */
	public static function getInstanceClosure ($obj, $methodName) {
		$result = ($obj->__hx_closureCache[$methodName] ?? null);
		if ($result !== null) {
			return $result;
		}
		if (!\method_exists($obj, $methodName) && !isset($obj->{$methodName})) {
			return null;
		}
		$result = new HxClosure($obj, $methodName);
		if (!\property_exists($obj, "__hx_closureCache")) {
			$obj->__hx_closureCache = [];
		}
		$obj->__hx_closureCache[$methodName] = $result;
		return $result;
	}

	/**
	 * Retrieve metadata for specified class
	 * 
	 * @param string $phpClassName
	 * 
	 * @return mixed
	 */
	public static function getMeta ($phpClassName) {
		if (!\class_exists($phpClassName)) {
			\interface_exists($phpClassName);
		}
		if (isset(Boot::$meta[$phpClassName])) {
			return Boot::$meta[$phpClassName];
		} else {
			return null;
		}
	}

	/**
	 * Find corresponding PHP class name.
	 * Returns `null` if specified class does not exist.
	 * 
	 * @param string $haxeName
	 * 
	 * @return string
	 */
	public static function getPhpName ($haxeName) {
		$prefix = Boot::getPrefix();
		$phpParts = (\strlen($prefix) === 0 ? new \Array_hx() : \Array_hx::wrap([$prefix]));
		$haxeParts = HxString::split($haxeName, ".");
		$_g = 0;
		while ($_g < $haxeParts->length) {
			$part = ($haxeParts->arr[$_g] ?? null);
			++$_g;
			if (Boot::isPhpKeyword($part)) {
				$part = ($part??'null') . "_hx";
			}
			$phpParts->arr[$phpParts->length++] = $part;
		}
		return $phpParts->join("\\");
	}

	/**
	 * Returns root namespace based on a value of `-D php-prefix=value` compiler flag.
	 * Returns empty string if no `-D php-prefix=value` provided.
	 * 
	 * @return string
	 */
	public static function getPrefix () {
		return self::PHP_PREFIX;
	}

	/**
	 * Returns a list of phpName=>haxeName for currently loaded haxe-generated classes.
	 * 
	 * @return mixed
	 */
	public static function getRegisteredAliases () {
		return Boot::$aliases;
	}

	/**
	 * Returns a list of currently loaded haxe-generated classes.
	 * 
	 * @return \Array_hx
	 */
	public static function getRegisteredClasses () {
		$result = new \Array_hx();
		$collection = Boot::$aliases;
		foreach ($collection as $key => $value) {
			$x = Boot::getClass($key);
			$result->arr[$result->length++] = $x;
		}
		return $result;
	}

	/**
	 * Creates Haxe-compatible closure of a static method.
	 * 
	 * @param string $phpClassName
	 * @param string $methodName
	 * 
	 * @return HxClosure
	 */
	public static function getStaticClosure ($phpClassName, $methodName) {
		$result = (Boot::$staticClosures[$phpClassName][$methodName] ?? null);
		if ($result !== null) {
			return $result;
		}
		$result = new HxClosure($phpClassName, $methodName);
		if (!\array_key_exists($phpClassName, Boot::$staticClosures)) {
			$this1 = [];
			Boot::$staticClosures[$phpClassName] = $this1;
		}
		Boot::$staticClosures[$phpClassName][$methodName] = $result;
		return $result;
	}

	/**
	 * Check if specified property has getter
	 * 
	 * @param string $phpClassName
	 * @param string $property
	 * 
	 * @return bool
	 */
	public static function hasGetter ($phpClassName, $property) {
		if (!\class_exists($phpClassName)) {
			\interface_exists($phpClassName);
		}
		$has = false;
		$phpClassName1 = $phpClassName;
		while (true) {
			$has = isset(Boot::$getters[$phpClassName1][$property]);
			$phpClassName1 = \get_parent_class($phpClassName1);
			if (!(!$has && ($phpClassName1 !== false) && \class_exists($phpClassName1))) {
				break;
			}
		}
		return $has;
	}

	/**
	 * Check if specified property has setter
	 * 
	 * @param string $phpClassName
	 * @param string $property
	 * 
	 * @return bool
	 */
	public static function hasSetter ($phpClassName, $property) {
		if (!\class_exists($phpClassName)) {
			\interface_exists($phpClassName);
		}
		$has = false;
		$phpClassName1 = $phpClassName;
		while (true) {
			$has = isset(Boot::$setters[$phpClassName1][$property]);
			$phpClassName1 = \get_parent_class($phpClassName1);
			if (!(!$has && ($phpClassName1 !== false) && \class_exists($phpClassName1))) {
				break;
			}
		}
		return $has;
	}

	/**
	 * @param mixed $value
	 * @param HxClass $type
	 * 
	 * @return bool
	 */
	public static function is ($value, $type) {
		return Boot::isOfType($value, $type);
	}

	/**
	 * Check if provided value is an anonymous object
	 * 
	 * @param mixed $v
	 * 
	 * @return bool
	 */
	public static function isAnon ($v) {
		return ($v instanceof HxAnon);
	}

	/**
	 * Check if `value` is a `Class<T>`
	 * 
	 * @param mixed $value
	 * 
	 * @return bool
	 */
	public static function isClass ($value) {
		return ($value instanceof HxClass);
	}

	/**
	 * Check if `value` is an enum constructor instance
	 * 
	 * @param mixed $value
	 * 
	 * @return bool
	 */
	public static function isEnumValue ($value) {
		return ($value instanceof HxEnum);
	}

	/**
	 * Check if `value` is a function
	 * 
	 * @param mixed $value
	 * 
	 * @return bool
	 */
	public static function isFunction ($value) {
		if (!($value instanceof \Closure)) {
			return ($value instanceof HxClosure);
		} else {
			return true;
		}
	}

	/**
	 * Check if `value` is an instance of `HxClosure`
	 * 
	 * @param mixed $value
	 * 
	 * @return bool
	 */
	public static function isHxClosure ($value) {
		return ($value instanceof HxClosure);
	}

	/**
	 * @param mixed $value
	 * 
	 * @return bool
	 */
	public static function isNumber ($value) {
		if (!\is_int($value)) {
			return \is_float($value);
		} else {
			return true;
		}
	}

	/**
	 * `Std.isOfType()` implementation
	 * 
	 * @param mixed $value
	 * @param HxClass $type
	 * 
	 * @return bool
	 */
	public static function isOfType ($value, $type) {
		if ($type === null) {
			return false;
		}
		$phpType = $type->phpClassName;
		if ($phpType === "Bool") {
			return \is_bool($value);
		} else if ($phpType === "Dynamic") {
			return $value !== null;
		} else if ($phpType === "Class" || $phpType === "Enum") {
			if (($value instanceof HxClass)) {
				$isEnumType = \is_subclass_of($value->phpClassName, Boot::getClass(HxEnum::class)->phpClassName);
				if ($phpType === "Enum") {
					return $isEnumType;
				} else {
					return !$isEnumType;
				}
			}
		} else if ($phpType === "Float") {
			if (!\is_float($value)) {
				return \is_int($value);
			} else {
				return true;
			}
		} else if ($phpType === "Int") {
			if (\is_int($value) || (\is_float($value) && ((int)($value) == $value) && !\is_nan($value))) {
				return \abs($value) <= 2147483648;
			} else {
				return false;
			}
		} else if ($phpType === "String") {
			return \is_string($value);
		} else if ($phpType === "php\\NativeArray" || $phpType === "php\\_NativeArray\\NativeArray_Impl_") {
			return \is_array($value);
		} else {
			if (\is_object($value)) {
				$tmp = $type;
				return ($value instanceof $tmp->phpClassName);
			}
		}
		return false;
	}

	/**
	 * Check if the value of `str` is a reserved keyword in PHP
	 * @see https://www.php.net/manual/en/reserved.keywords.php
	 * 
	 * @param string $str
	 * 
	 * @return bool
	 */
	public static function isPhpKeyword ($str) {
		switch(strtolower($str)) {
			case '__halt_compiler': case 'abstract': case 'and': case 'array': case 'as': case 'break': 
			case 'callable': case 'case': case 'catch': case 'class': case 'clone': case 'const': case 'continue': 
			case 'declare': case 'default': case 'die': case 'do': case 'echo': case 'else': case 'elseif': 
			case 'empty': case 'enddeclare': case 'endfor': case 'endforeach': case 'endif': case 'endswitch': case 'endwhile': 
			case 'eval': case 'exit': case 'extends': case 'final': case 'finally': case 'for': case 'foreach': 
			case 'function': case 'global': case 'goto': case 'if': case 'implements': case 'include': case 'include_once': 
			case 'instanceof': case 'insteadof': case 'interface': case 'isset': case 'list': case 'namespace': case 'new': 
			case 'or': case 'print': case 'private': case 'protected': case 'public': case 'require': case 'require_once': 
			case 'return': case 'static': case 'switch': case 'throw': case 'trait': case 'try': case 'unset': 
			case 'use': case 'var': case 'while': case 'xor': case 'yield': case '__class__': case '__dir__': 
			case '__file__': case '__function__': case '__line__': case '__method__': case '__trait__': case '__namespace__': case 'int': 
			case 'float': case 'bool': case 'string': case 'true': case 'false': case 'null': case 'parent': 
			case 'void': case 'iterable': case 'object': case 'fn': 
				return true;
			default:
				return false;
		}
	}

	/**
	 * Associate PHP class name with Haxe class name
	 * 
	 * @param string $phpClassName
	 * @param string $haxeClassName
	 * 
	 * @return void
	 */
	public static function registerClass ($phpClassName, $haxeClassName) {
		Boot::$aliases[$phpClassName] = $haxeClassName;
	}

	/**
	 * Register list of getters to be able to call getters using reflection
	 * 
	 * @param string $phpClassName
	 * @param mixed $list
	 * 
	 * @return void
	 */
	public static function registerGetters ($phpClassName, $list) {
		Boot::$getters[$phpClassName] = $list;
	}

	/**
	 * Save metadata for specified class
	 * 
	 * @param string $phpClassName
	 * @param mixed $data
	 * 
	 * @return void
	 */
	public static function registerMeta ($phpClassName, $data) {
		Boot::$meta[$phpClassName] = $data;
	}

	/**
	 * Register list of setters to be able to call getters using reflection
	 * 
	 * @param string $phpClassName
	 * @param mixed $list
	 * 
	 * @return void
	 */
	public static function registerSetters ($phpClassName, $list) {
		Boot::$setters[$phpClassName] = $list;
	}

	/**
	 * Performs `left >>> right` operation
	 * 
	 * @param int $left
	 * @param int $right
	 * 
	 * @return int
	 */
	public static function shiftRightUnsigned ($left, $right) {
		if ($right === 0) {
			return $left;
		} else if ($left >= 0) {
			return ($left >> $right) & ~((1 << (8 * \PHP_INT_SIZE - 1)) >> ($right - 1));
		} else {
			return ($left >> $right) & (2147483647 >> ($right - 1));
		}
	}

	/**
	 * Returns string representation of `value`
	 * 
	 * @param mixed $value
	 * @param int $maxRecursion
	 * 
	 * @return string
	 */
	public static function stringify ($value, $maxRecursion = 10) {
		if ($maxRecursion === null) {
			$maxRecursion = 10;
		}
		if ($maxRecursion <= 0) {
			return "<...>";
		}
		if ($value === null) {
			return "null";
		}
		if (\is_string($value)) {
			return $value;
		}
		if (\is_int($value) || \is_float($value)) {
			return (string)($value);
		}
		if (\is_bool($value)) {
			if ($value) {
				return "true";
			} else {
				return "false";
			}
		}
		if (\is_array($value)) {
			$strings = [];
			foreach ($value as $key => $value1) {
				$strings[] = (((string)($key)??'null') . " => " . (Boot::stringify($value1, $maxRecursion - 1)??'null'));
			}
			return "[" . (\implode(", ", $strings)??'null') . "]";
		}
		if (\is_object($value)) {
			if (($value instanceof \Array_hx)) {
				$arr = Boot::dynamicField($value, 'arr');
				$maxRecursion1 = $maxRecursion - 1;
				if ($maxRecursion1 === null) {
					$maxRecursion1 = 10;
				}
				$strings = [];
				foreach ($arr as $key => $value1) {
					$strings[$key] = Boot::stringify($value1, $maxRecursion1 - 1);
				}
				return "[" . (\implode(",", $strings)??'null') . "]";
			}
			if (($value instanceof HxEnum)) {
				$e = $value;
				$result = $e->tag;
				if (\count($e->params) > 0) {
					$result = ($result??'null') . "(" . (\implode(",", \array_map(function ($item) use (&$maxRecursion) {
						return Boot::stringify($item, $maxRecursion - 1);
					}, $e->params))??'null') . ")";
				}
				return $result;
			}
			if (\method_exists($value, "toString")) {
				return HxDynamicStr::wrap($value)->toString();
			}
			if (\method_exists($value, "__toString")) {
				return $value->__toString();
			}
			if (($value instanceof \StdClass)) {
				if (isset($value->toString) && \is_callable(Boot::dynamicField($value, 'toString'))) {
					return HxDynamicStr::wrap($value)->toString();
				}
				$result = [];
				$data = \get_object_vars($value);
				$data1 = \array_keys($data);
				$_g_current = 0;
				$_g_length = \count($data1);
				while ($_g_current < $_g_length) {
					$key = $data1[$_g_current++];
					\array_push($result, "" . ($key??'null') . " : " . (Boot::stringify($data[$key], $maxRecursion - 1)??'null'));
				}
				return "{ " . (\implode(", ", $result)??'null') . " }";
			}
			if (($value instanceof \Closure) || ($value instanceof HxClosure)) {
				return "<function>";
			}
			if (($value instanceof HxClass)) {
				return "[class " . (Boot::getClassName($value->phpClassName)??'null') . "]";
			} else {
				return "[object " . (Boot::getClassName(\get_class($value))??'null') . "]";
			}
		}
		throw Exception::thrown("Unable to stringify value");
	}

	/**
	 * @param mixed $arr
	 * @param int $maxRecursion
	 * 
	 * @return string
	 */
	public static function stringifyNativeIndexedArray ($arr, $maxRecursion = 10) {
		if ($maxRecursion === null) {
			$maxRecursion = 10;
		}
		$strings = [];
		foreach ($arr as $key => $value) {
			$strings[$key] = Boot::stringify($value, $maxRecursion - 1);
		}
		return "[" . (\implode(",", $strings)??'null') . "]";
	}

	/**
	 * Implementation for `cast(value, Class<Dynamic>)`
	 * @throws haxe.ValueError if `value` cannot be casted to this type
	 * 
	 * @param HxClass $hxClass
	 * @param mixed $value
	 * 
	 * @return mixed
	 */
	public static function typedCast ($hxClass, $value) {
		if ($value === null) {
			return null;
		}
		$__hx__switch = ($hxClass->phpClassName);
		if ($__hx__switch === "Bool") {
			if (\is_bool($value)) {
				return $value;
			}
		} else if ($__hx__switch === "Float") {
			if (\is_int($value) || \is_float($value)) {
				return \floatval($value);
			}
		} else if ($__hx__switch === "Int") {
			if (\is_int($value) || \is_float($value)) {
				return \intval($value);
			}
		} else if ($__hx__switch === "String") {
			if (\is_string($value)) {
				return $value;
			}
		} else if ($__hx__switch === "php\\NativeArray") {
			if (\is_array($value)) {
				return $value;
			}
		} else {
			if (\is_object($value) && Boot::isOfType($value, $hxClass)) {
				return $value;
			}
		}
		throw Exception::thrown("Cannot cast " . (\Std::string($value)??'null') . " to " . (Boot::getClassName($hxClass->phpClassName)??'null'));
	}

	/**
	 * Get UTF-8 code of the first character in `s` without any checks
	 * 
	 * @param mixed $s
	 * 
	 * @return int
	 */
	public static function unsafeOrd ($s) {
		$code = \ord($s[0]);
		if ($code < 192) {
			return $code;
		} else if ($code < 224) {
			return (($code - 192) << 6) + \ord($s[1]) - 128;
		} else if ($code < 240) {
			return (($code - 224) << 12) + ((\ord($s[1]) - 128) << 6) + \ord($s[2]) - 128;
		} else {
			return (($code - 240) << 18) + ((\ord($s[1]) - 128) << 12) + ((\ord($s[2]) - 128) << 6) + \ord($s[3]) - 128;
		}
	}

	/**
	 * @internal
	 * @access private
	 */
	static public function __hx__init ()
	{
		static $called = false;
		if ($called) return;
		$called = true;

		\mb_internal_encoding("UTF-8");
		if (!\defined("HAXE_CUSTOM_ERROR_HANDLER") || !\HAXE_CUSTOM_ERROR_HANDLER) {
			$previousLevel = \error_reporting(\E_ALL);
			$previousHandler = \set_error_handler(function ($errno, $errstr, $errfile, $errline) {
				if ((\error_reporting() & $errno) === 0) {
					return false;
				}
				if (($errno === \E_WARNING) && ($errstr === "Division by zero")) {
					return true;
				}
				throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
			});
			if ($previousHandler !== null) {
				\error_reporting($previousLevel);
				\set_error_handler($previousHandler);
			}
		}

		self::$aliases = [];
		self::$classes = [];
		self::$getters = [];
		self::$setters = [];
		self::$meta = [];
		self::$staticClosures = [];
	}
}

require_once __DIR__.'/_polyfills.php';
Boot::__hx__init();
Boot::registerClass(Boot::class, 'php.Boot');
\php\Web::__hx__init();
\php\Session::__hx__init();
