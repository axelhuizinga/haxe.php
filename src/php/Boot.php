<?php
/**
 * Generated by Haxe 4.0.5
 */

namespace php;

use \php\_Boot\HxDynamicStr;
use \php\_Boot\HxAnon;
use \php\_Boot\HxClass;
use \php\_Boot\HxString;
use \php\_Boot\HxClosure;
use \php\_Boot\HxException;
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
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:450: lines 450-452
		if (is_string($left) || is_string($right)) {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:451: characters 4-45
			return ($left??'null') . ($right??'null');
		}
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:453: characters 3-33
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
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:299: characters 3-18
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
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:292: characters 3-15
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
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:306: characters 3-18
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
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:622: characters 10-96
		if (is_string($target)) {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:622: characters 31-61
			return Boot::getStaticClosure($target, $func);
		} else {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:622: characters 64-96
			return Boot::getInstanceClosure($target, $func);
		}
	}

	/**
	 * Returns `Class<T>` for `HxClosure`
	 * 
	 * @return HxClass
	 */
	public static function closureHxClass () {
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:313: characters 3-24
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
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:556: characters 3-26
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
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:549: characters 3-15
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
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:570: lines 570-572
		if (method_exists($value, $field)) {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:571: characters 11-32
			if (is_string($value)) {
				return Boot::getStaticClosure($value, $field);
			} else {
				return Boot::getInstanceClosure($value, $field);
			}
		}
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:573: lines 573-575
		if (is_string($value)) {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:574: characters 4-51
			$value = new HxDynamicStr($value);
		}
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:576: characters 23-28
		$tmp = $value;
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:576: characters 3-36
		return $tmp->{$field};
	}

	/**
	 * @param string $str
	 * 
	 * @return HxDynamicStr
	 */
	public static function dynamicString ($str) {
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:580: characters 3-47
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
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:563: characters 10-84
		if (!class_exists($phpClassName)) {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:563: characters 47-84
			return interface_exists($phpClassName);
		} else {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:563: characters 10-84
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
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:436: lines 436-438
		if ((is_int($left) || is_float($left)) && (is_int($right) || is_float($right))) {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:437: characters 4-36
			return ($left == $right);
		}
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:439: lines 439-441
		if (($left instanceof HxClosure) && ($right instanceof HxClosure)) {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:440: characters 4-43
			return $left->equals($right);
		}
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:442: characters 3-41
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
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:183: lines 183-185
		if (mb_substr($phpClassName, 0, 1) === "\\") {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:184: characters 19-41
			$phpClassName = mb_substr($phpClassName, 1, null);
		}
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:186: lines 186-188
		if (!isset(Boot::$classes[$phpClassName])) {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:187: characters 4-53
			$val = new HxClass($phpClassName);
			Boot::$classes[$phpClassName] = $val;
		}
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:190: characters 3-31
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
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:218: characters 3-40
		$hxClass = Boot::getClass($phpClassName);
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:219: characters 3-35
		$name = Boot::getHaxeName($hxClass);
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:220: characters 10-54
		if ($name === null) {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:220: characters 26-46
			return $hxClass->phpClassName;
		} else {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:220: characters 49-53
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
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:227: characters 11-31
		$__hx__switch = ($hxClass->phpClassName);
		if ($__hx__switch === "Bool") {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:233: characters 5-18
			return "Bool";
		} else if ($__hx__switch === "Class") {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:237: characters 5-19
			return "Class";
		} else if ($__hx__switch === "Dynamic") {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:241: characters 5-21
			return "Dynamic";
		} else if ($__hx__switch === "Enum") {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:239: characters 5-18
			return "Enum";
		} else if ($__hx__switch === "Float") {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:235: characters 5-19
			return "Float";
		} else if ($__hx__switch === "Int") {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:229: characters 5-17
			return "Int";
		} else if ($__hx__switch === "String") {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:231: characters 5-20
			return "String";
		} else {
		}
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:248: lines 248-254
		if (isset(Boot::$aliases[$hxClass->phpClassName])) {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:249: characters 4-40
			return Boot::$aliases[$hxClass->phpClassName];
		} else if (class_exists($hxClass->phpClassName) && isset(Boot::$aliases[$hxClass->phpClassName])) {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:251: characters 4-40
			return Boot::$aliases[$hxClass->phpClassName];
		} else if (interface_exists($hxClass->phpClassName) && isset(Boot::$aliases[$hxClass->phpClassName])) {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:253: characters 4-40
			return Boot::$aliases[$hxClass->phpClassName];
		}
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:256: characters 3-14
		return null;
	}

	/**
	 * Returns Class<HxAnon>
	 * 
	 * @return HxClass
	 */
	public static function getHxAnon () {
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:197: characters 3-21
		return Boot::getClass(HxAnon::class);
	}

	/**
	 * Returns Class<HxClass>
	 * 
	 * @return HxClass
	 */
	public static function getHxClass () {
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:211: characters 3-22
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
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:588: characters 3-73
		$result = ($obj->__hx_closureCache[$methodName] ?? null);
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:589: lines 589-591
		if ($result !== null) {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:590: characters 4-17
			return $result;
		}
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:592: characters 3-42
		$result = new HxClosure($obj, $methodName);
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:593: lines 593-595
		if (!property_exists($obj, "__hx_closureCache")) {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:594: characters 28-50
			$this1 = [];
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:594: characters 4-50
			$obj->__hx_closureCache = $this1;
		}
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:596: characters 3-45
		$obj->__hx_closureCache[$methodName] = $result;
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:597: characters 3-16
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
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:149: characters 3-29
		if (!class_exists($phpClassName)) {
			interface_exists($phpClassName);
		}
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:150: characters 10-70
		if (isset(Boot::$meta[$phpClassName])) {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:150: characters 45-63
			return Boot::$meta[$phpClassName];
		} else {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:150: characters 66-70
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
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:264: characters 3-28
		$prefix = Boot::getPrefix();
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:265: characters 3-63
		$phpParts = (strlen($prefix) === 0 ? new \Array_hx() : \Array_hx::wrap([$prefix]));
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:267: characters 3-39
		$haxeParts = HxString::split($haxeName, ".");
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:268: lines 268-273
		$_g = 0;
		while ($_g < $haxeParts->length) {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:268: characters 8-12
			$part = ($haxeParts->arr[$_g] ?? null);
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:268: lines 268-273
			++$_g;
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:269: lines 269-271
			if (Boot::isPhpKeyword($part)) {
				#C:\Program Files\Haxe\haxe\std/php/Boot.hx:270: characters 5-18
				$part = ($part??'null') . "_hx";
			}
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:272: characters 4-23
			$phpParts->arr[$phpParts->length] = $part;
			++$phpParts->length;

		}

		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:275: characters 3-29
		return $phpParts->join("\\");
	}

	/**
	 * Returns root namespace based on a value of `-D php-prefix=value` compiler flag.
	 * Returns empty string if no `-D php-prefix=value` provided.
	 * 
	 * @return string
	 */
	public static function getPrefix () {
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:89: characters 3-41
		return self::PHP_PREFIX;
	}

	/**
	 * Returns a list of phpName=>haxeName for currently loaded haxe-generated classes.
	 * 
	 * @return mixed
	 */
	public static function getRegisteredAliases () {
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:175: characters 3-17
		return Boot::$aliases;
	}

	/**
	 * Returns a list of currently loaded haxe-generated classes.
	 * 
	 * @return \Array_hx
	 */
	public static function getRegisteredClasses () {
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:164: characters 3-19
		$result = new \Array_hx();
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:165: lines 165-167
		$collection = Boot::$aliases;
		foreach ($collection as $key => $value) {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:166: characters 4-39
			$x = Boot::getClass($key);
			$result->arr[$result->length] = $x;
			++$result->length;

		}

		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:168: characters 3-16
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
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:604: characters 3-80
		$result = (Boot::$staticClosures[$phpClassName][$methodName] ?? null);
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:605: lines 605-607
		if ($result !== null) {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:606: characters 4-17
			return $result;
		}
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:608: characters 3-51
		$result = new HxClosure($phpClassName, $methodName);
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:609: lines 609-611
		if (!array_key_exists($phpClassName, Boot::$staticClosures)) {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:610: characters 35-57
			$this1 = [];
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:610: characters 4-57
			Boot::$staticClosures[$phpClassName] = $this1;
		}
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:612: characters 3-52
		Boot::$staticClosures[$phpClassName][$methodName] = $result;
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:613: characters 3-16
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
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:110: characters 3-29
		if (!class_exists($phpClassName)) {
			interface_exists($phpClassName);
		}
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:112: characters 3-19
		$has = false;
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:113: characters 3-72
		$phpClassName1 = $phpClassName;
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:114: lines 114-117
		while (true) {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:115: characters 4-55
			$has = isset(Boot::$getters[$phpClassName1][$property]);
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:116: characters 4-56
			$phpClassName1 = get_parent_class($phpClassName1);
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:114: lines 114-117
			if (!(!$has && ($phpClassName1 !== false) && class_exists($phpClassName1))) {
				break;
			}
		}
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:119: characters 3-13
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
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:126: characters 3-29
		if (!class_exists($phpClassName)) {
			interface_exists($phpClassName);
		}
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:128: characters 3-19
		$has = false;
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:129: characters 3-72
		$phpClassName1 = $phpClassName;
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:130: lines 130-133
		while (true) {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:131: characters 4-55
			$has = isset(Boot::$setters[$phpClassName1][$property]);
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:132: characters 4-56
			$phpClassName1 = get_parent_class($phpClassName1);
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:130: lines 130-133
			if (!(!$has && ($phpClassName1 !== false) && class_exists($phpClassName1))) {
				break;
			}
		}
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:135: characters 3-13
		return $has;
	}

	/**
	 * `Std.is()` implementation
	 * 
	 * @param mixed $value
	 * @param HxClass $type
	 * 
	 * @return bool
	 */
	public static function is ($value, $type) {
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:460: lines 460-461
		if ($type === null) {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:461: characters 4-16
			return false;
		}
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:463: characters 3-35
		$phpType = $type->phpClassName;
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:471: lines 471-497
		if ($phpType === "Bool") {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:480: characters 5-27
			return is_bool($value);
		} else if ($phpType === "Dynamic") {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:473: characters 5-25
			return $value !== null;
		} else if ($phpType === "Class" || $phpType === "Enum") {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:486: lines 486-491
			if (($value instanceof HxClass)) {
				#C:\Program Files\Haxe\haxe\std/php/Boot.hx:487: characters 6-62
				$valuePhpClass = $value->phpClassName;
				#C:\Program Files\Haxe\haxe\std/php/Boot.hx:488: characters 6-62
				$enumPhpClass = Boot::getClass(HxEnum::class)->phpClassName;
				#C:\Program Files\Haxe\haxe\std/php/Boot.hx:489: characters 6-74
				$isEnumType = is_subclass_of($valuePhpClass, $enumPhpClass);
				#C:\Program Files\Haxe\haxe\std/php/Boot.hx:490: characters 13-59
				if ($phpType === "Enum") {
					#C:\Program Files\Haxe\haxe\std/php/Boot.hx:490: characters 34-44
					return $isEnumType;
				} else {
					#C:\Program Files\Haxe\haxe\std/php/Boot.hx:490: characters 47-58
					return !$isEnumType;
				}
			}
		} else if ($phpType === "Float") {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:478: characters 12-46
			if (!is_float($value)) {
				#C:\Program Files\Haxe\haxe\std/php/Boot.hx:478: characters 32-46
				return is_int($value);
			} else {
				#C:\Program Files\Haxe\haxe\std/php/Boot.hx:478: characters 12-46
				return true;
			}
		} else if ($phpType === "Int") {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:475: lines 475-476
			if (is_int($value) || (is_float($value) && ((int)($value) == $value) && !is_nan($value))) {
				#C:\Program Files\Haxe\haxe\std/php/Boot.hx:476: characters 9-40
				return abs($value) <= 2147483648;
			} else {
				#C:\Program Files\Haxe\haxe\std/php/Boot.hx:475: lines 475-476
				return false;
			}
		} else if ($phpType === "String") {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:482: characters 5-29
			return is_string($value);
		} else if ($phpType === "php\\NativeArray" || $phpType === "php\\_NativeArray\\NativeArray_Impl_") {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:484: characters 5-28
			return is_array($value);
		} else {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:493: lines 493-496
			if (is_object($value)) {
				#C:\Program Files\Haxe\haxe\std/php/Boot.hx:494: characters 6-42
				$type1 = $type;
				#C:\Program Files\Haxe\haxe\std/php/Boot.hx:495: characters 31-36
				$tmp = $value;
				#C:\Program Files\Haxe\haxe\std/php/Boot.hx:495: characters 38-42
				$tmp1 = $type1;
				#C:\Program Files\Haxe\haxe\std/php/Boot.hx:495: characters 6-43
				return ($tmp instanceof $tmp1->phpClassName);
			}
		}
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:498: characters 3-15
		return false;
	}

	/**
	 * Check if provided value is an anonymous object
	 * 
	 * @param mixed $v
	 * 
	 * @return bool
	 */
	public static function isAnon ($v) {
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:204: characters 3-27
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
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:505: characters 3-32
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
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:512: characters 3-31
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
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:519: characters 10-60
		if (!($value instanceof \Closure)) {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:519: characters 36-60
			return ($value instanceof HxClosure);
		} else {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:519: characters 10-60
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
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:526: characters 3-34
		return ($value instanceof HxClosure);
	}

	/**
	 * @param mixed $value
	 * 
	 * @return bool
	 */
	public static function isNumber ($value) {
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:429: characters 10-44
		if (!is_int($value)) {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:429: characters 28-44
			return is_float($value);
		} else {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:429: characters 10-44
			return true;
		}
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
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:157: characters 3-40
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
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:96: characters 3-31
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
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:142: characters 3-28
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
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:103: characters 3-31
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
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:533: lines 533-539
		if ($right === 0) {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:534: characters 4-15
			return $left;
		} else if ($left >= 0) {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:536: characters 4-82
			return ($left >> $right) & ~((1 << (8 * PHP_INT_SIZE - 1)) >> ($right - 1));
		} else {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:538: characters 4-56
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
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:355: lines 355-418
		if ($maxRecursion === null) {
			$maxRecursion = 10;
		}
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:356: lines 356-358
		if ($maxRecursion <= 0) {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:357: characters 4-18
			return "<...>";
		}
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:359: lines 359-361
		if ($value === null) {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:360: characters 4-17
			return "null";
		}
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:362: lines 362-364
		if (is_string($value)) {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:363: characters 4-16
			return $value;
		}
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:365: lines 365-367
		if (is_int($value) || is_float($value)) {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:366: characters 4-31
			return (string)($value);
		}
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:368: lines 368-370
		if (is_bool($value)) {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:369: characters 11-35
			if ($value) {
				#C:\Program Files\Haxe\haxe\std/php/Boot.hx:369: characters 20-24
				return "true";
			} else {
				#C:\Program Files\Haxe\haxe\std/php/Boot.hx:369: characters 29-34
				return "false";
			}
		}
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:371: lines 371-377
		if (is_array($value)) {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:372: characters 4-37
			$strings = [];
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:373: lines 373-375
			$collection = $value;
			foreach ($collection as $key => $value1) {
				#C:\Program Files\Haxe\haxe\std/php/Boot.hx:374: characters 5-82
				$strings[] = (((string)($key)??'null') . " => " . (Boot::stringify($value1, $maxRecursion - 1)??'null'));
			}

			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:376: characters 4-52
			return "[" . (implode(", ", $strings)??'null') . "]";
		}
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:378: lines 378-416
		if (is_object($value)) {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:379: lines 379-381
			if (($value instanceof \Array_hx)) {
				#C:\Program Files\Haxe\haxe\std/php/Boot.hx:380: characters 5-75
				return Boot::stringifyNativeIndexedArray(Boot::dynamicField($value, 'arr'), $maxRecursion - 1);
			}
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:382: lines 382-390
			if (($value instanceof HxEnum)) {
				#C:\Program Files\Haxe\haxe\std/php/Boot.hx:383: characters 5-26
				$e = $value;
				#C:\Program Files\Haxe\haxe\std/php/Boot.hx:384: characters 5-24
				$result = $e->tag;
				#C:\Program Files\Haxe\haxe\std/php/Boot.hx:385: lines 385-388
				if (count($e->params) > 0) {
					#C:\Program Files\Haxe\haxe\std/php/Boot.hx:386: characters 6-109
					$strings1 = array_map(function ($item)  use (&$maxRecursion) {
						#C:\Program Files\Haxe\haxe\std/php/Boot.hx:386: characters 52-97
						return Boot::stringify($item, $maxRecursion - 1);
					}, $e->params);
					#C:\Program Files\Haxe\haxe\std/php/Boot.hx:387: characters 6-56
					$result = ($result??'null') . "(" . (implode(",", $strings1)??'null') . ")";
				}
				#C:\Program Files\Haxe\haxe\std/php/Boot.hx:389: characters 5-18
				return $result;
			}
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:391: lines 391-393
			if (method_exists($value, "toString")) {
				#C:\Program Files\Haxe\haxe\std/php/Boot.hx:392: characters 5-28
				return HxDynamicStr::wrap($value)->toString();
			}
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:394: lines 394-396
			if (method_exists($value, "__toString")) {
				#C:\Program Files\Haxe\haxe\std/php/Boot.hx:395: characters 5-30
				return $value->__toString();
			}
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:397: lines 397-407
			if (($value instanceof \StdClass)) {
				#C:\Program Files\Haxe\haxe\std/php/Boot.hx:398: characters 35-40
				$tmp = $value;
				#C:\Program Files\Haxe\haxe\std/php/Boot.hx:398: lines 398-400
				if (isset($tmp->{"toString"}) && is_callable(Boot::dynamicField($value, 'toString'))) {
					#C:\Program Files\Haxe\haxe\std/php/Boot.hx:399: characters 6-29
					return HxDynamicStr::wrap($value)->toString();
				}
				#C:\Program Files\Haxe\haxe\std/php/Boot.hx:401: characters 18-50
				$this1 = [];
				#C:\Program Files\Haxe\haxe\std/php/Boot.hx:401: characters 5-51
				$result1 = $this1;
				#C:\Program Files\Haxe\haxe\std/php/Boot.hx:402: characters 5-46
				$data = get_object_vars($value);
				#C:\Program Files\Haxe\haxe\std/php/Boot.hx:403: characters 17-34
				$data1 = array_keys($data);
				$_g_current = 0;
				$_g_length = count($data1);
				$_g_data = $data1;
				#C:\Program Files\Haxe\haxe\std/php/Boot.hx:403: lines 403-405
				while ($_g_current < $_g_length) {
					$key1 = $_g_data[$_g_current++];
					#C:\Program Files\Haxe\haxe\std/php/Boot.hx:404: characters 24-74
					$tmp1 = "" . ($key1??'null') . " : " . (Boot::stringify($data[$key1], $maxRecursion - 1)??'null');
					#C:\Program Files\Haxe\haxe\std/php/Boot.hx:404: characters 6-75
					array_push($result1, $tmp1);
				}

				#C:\Program Files\Haxe\haxe\std/php/Boot.hx:406: characters 5-54
				return "{ " . (implode(", ", $result1)??'null') . " }";
			}
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:408: lines 408-410
			if (($value instanceof \Closure) || ($value instanceof HxClosure)) {
				#C:\Program Files\Haxe\haxe\std/php/Boot.hx:409: characters 5-24
				return "<function>";
			}
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:411: lines 411-415
			if (($value instanceof HxClass)) {
				#C:\Program Files\Haxe\haxe\std/php/Boot.hx:412: characters 5-74
				return "[class " . (Boot::getClassName($value->phpClassName)??'null') . "]";
			} else {
				#C:\Program Files\Haxe\haxe\std/php/Boot.hx:414: characters 5-68
				return "[object " . (Boot::getClassName(get_class($value))??'null') . "]";
			}
		}
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:417: characters 3-8
		throw new HxException("Unable to stringify value");
	}

	/**
	 * @param mixed $arr
	 * @param int $maxRecursion
	 * 
	 * @return string
	 */
	public static function stringifyNativeIndexedArray ($arr, $maxRecursion = 10) {
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:420: lines 420-426
		if ($maxRecursion === null) {
			$maxRecursion = 10;
		}
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:421: characters 3-36
		$strings = [];
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:422: lines 422-424
		foreach ($arr as $key => $value) {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:423: characters 4-60
			$strings[$key] = Boot::stringify($value, $maxRecursion - 1);
		}
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:425: characters 3-50
		return "[" . (implode(",", $strings)??'null') . "]";
	}

	/**
	 * Implementation for `cast(value, Class<Dynamic>)`
	 * @throws HxException if `value` cannot be casted to this type
	 * 
	 * @param HxClass $hxClass
	 * @param mixed $value
	 * 
	 * @return mixed
	 */
	public static function typedCast ($hxClass, $value) {
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:321: lines 321-322
		if ($value === null) {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:322: characters 4-15
			return null;
		}
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:323: characters 11-31
		$__hx__switch = ($hxClass->phpClassName);
		if ($__hx__switch === "Bool") {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:333: lines 333-335
			if (is_bool($value)) {
				#C:\Program Files\Haxe\haxe\std/php/Boot.hx:334: characters 6-18
				return $value;
			}
		} else if ($__hx__switch === "Float") {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:329: lines 329-331
			if (is_int($value) || is_float($value)) {
				#C:\Program Files\Haxe\haxe\std/php/Boot.hx:330: characters 6-29
				return floatval($value);
			}
		} else if ($__hx__switch === "Int") {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:325: lines 325-327
			if (is_int($value) || is_float($value)) {
				#C:\Program Files\Haxe\haxe\std/php/Boot.hx:326: characters 6-33
				return intval($value);
			}
		} else if ($__hx__switch === "String") {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:337: lines 337-339
			if (is_string($value)) {
				#C:\Program Files\Haxe\haxe\std/php/Boot.hx:338: characters 6-18
				return $value;
			}
		} else if ($__hx__switch === "php\\NativeArray") {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:341: lines 341-343
			if (is_array($value)) {
				#C:\Program Files\Haxe\haxe\std/php/Boot.hx:342: characters 6-18
				return $value;
			}
		} else {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:345: lines 345-347
			if (is_object($value) && Boot::is($value, $hxClass)) {
				#C:\Program Files\Haxe\haxe\std/php/Boot.hx:346: characters 6-18
				return $value;
			}
		}
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:349: characters 3-8
		throw new HxException("Cannot cast " . (\Std::string($value)??'null') . " to " . (Boot::getClassName($hxClass->phpClassName)??'null'));
	}

	/**
	 * Get UTF-8 code of the first character in `s` without any checks
	 * 
	 * @param mixed $s
	 * 
	 * @return int
	 */
	public static function unsafeOrd ($s) {
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:629: characters 3-31
		$code = ord($s[0]);
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:630: lines 630-638
		if ($code < 192) {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:631: characters 4-15
			return $code;
		} else if ($code < 224) {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:633: characters 4-57
			return (($code - 192) << 6) + ord($s[1]) - 128;
		} else if ($code < 240) {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:635: characters 4-93
			return (($code - 224) << 12) + ((ord($s[1]) - 128) << 6) + ord($s[2]) - 128;
		} else {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:637: characters 4-129
			return (($code - 240) << 18) + ((ord($s[1]) - 128) << 12) + ((ord($s[2]) - 128) << 6) + ord($s[3]) - 128;
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

		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:60: characters 3-39
		mb_internal_encoding("UTF-8");
		#C:\Program Files\Haxe\haxe\std/php/Boot.hx:61: lines 61-81
		if (!defined("HAXE_CUSTOM_ERROR_HANDLER") || !HAXE_CUSTOM_ERROR_HANDLER) {
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:62: characters 4-60
			$previousLevel = error_reporting(E_ALL);
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:63: lines 63-75
			$previousHandler = set_error_handler(function ($errno, $errstr, $errfile, $errline) {
				#C:\Program Files\Haxe\haxe\std/php/Boot.hx:64: lines 64-66
				if ((error_reporting() & $errno) === 0) {
					#C:\Program Files\Haxe\haxe\std/php/Boot.hx:65: characters 6-18
					return false;
				}
				#C:\Program Files\Haxe\haxe\std/php/Boot.hx:71: lines 71-73
				if (($errno === E_WARNING) && ($errstr === "Division by zero")) {
					#C:\Program Files\Haxe\haxe\std/php/Boot.hx:72: characters 6-17
					return true;
				}
				#C:\Program Files\Haxe\haxe\std/php/Boot.hx:74: characters 5-10
				throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
			});
			#C:\Program Files\Haxe\haxe\std/php/Boot.hx:77: lines 77-80
			if ($previousHandler !== null) {
				#C:\Program Files\Haxe\haxe\std/php/Boot.hx:78: characters 5-42
				error_reporting($previousLevel);
				#C:\Program Files\Haxe\haxe\std/php/Boot.hx:79: characters 5-46
				set_error_handler($previousHandler);
			}
		}

		$this1 = [];
		self::$aliases = $this1;
		$this1 = [];
		self::$classes = $this1;
		$this1 = [];
		self::$getters = $this1;
		$this1 = [];
		self::$setters = $this1;
		$this1 = [];
		self::$meta = $this1;
		$this1 = [];
		self::$staticClosures = $this1;
	}
}

require_once __DIR__.'/_polyfills.php';
Boot::__hx__init();
Boot::registerClass(Boot::class, 'php.Boot');
