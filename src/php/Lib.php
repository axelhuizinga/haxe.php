<?php
/**
 * Generated by Haxe 4.1.0
 */

namespace php;

use \php\_Boot\HxAnon;
use \haxe\Exception;
use \php\_Boot\HxString;
use \haxe\ds\StringMap;

/**
 * Platform-specific PHP Library. Provides some platform-specific functions
 * for the PHP target, such as conversion from Haxe types to native types
 * and vice-versa.
 */
class Lib {
	/**
	 * @var bool
	 */
	static public $loaded = false;

	/**
	 * @param StringMap $hash
	 * 
	 * @return mixed
	 */
	public static function associativeArrayOfHash ($hash) {
		return $hash->data;
	}

	/**
	 * @param mixed $ob
	 * 
	 * @return mixed
	 */
	public static function associativeArrayOfObject ($ob) {
		return ((array)($ob));
	}

	/**
	 * Displays structured information about one or more expressions
	 * that includes its type and value. Arrays and objects are
	 * explored recursively with values indented to show structure.
	 * 
	 * @param mixed $v
	 * 
	 * @return void
	 */
	public static function dump ($v) {
		var_dump($v);
	}

	/**
	 * Find out whether an extension is loaded.
	 * 
	 * @param string $name
	 * 
	 * @return bool
	 */
	public static function extensionLoaded ($name) {
		return extension_loaded($name);
	}

	/**
	 * Tries to load all compiled php files and returns list of types.
	 * 
	 * @return mixed
	 */
	public static function getClasses () {
		if (!Lib::$loaded) {
			Lib::$loaded = true;
			Lib::loadLib(dirname((new \ReflectionClass(Boot::getPhpName("php.Boot")))->getFileName(), 2));
		}
		$result = new HxAnon();
		$collection = Boot::getRegisteredAliases();
		foreach ($collection as $key => $value) {
			$parts = HxString::split($value, ".");
			$obj = $result;
			while ($parts->length > 1) {
				if ($parts->length > 0) {
					$parts->length--;
				}
				$pack = array_shift($parts->arr);
				$tmp = $obj;
				if ($tmp->{$pack} === null) {
					$tmp1 = $obj;
					$tmp1->{$pack} = new HxAnon();
				}
				$tmp2 = $obj;
				$obj = $tmp2->{$pack};
			}
			$tmp3 = $obj;
			$tmp3->{($parts->arr[0] ?? null)} = Boot::getClass($key);
		}
		return $result;
	}

	/**
	 * @param mixed $arr
	 * 
	 * @return StringMap
	 */
	public static function hashOfAssociativeArray ($arr) {
		$result = new StringMap();
		$result->data = $arr;
		return $result;
	}

	/**
	 * @return bool
	 */
	public static function isCli () {
		return 0 === strncasecmp(PHP_SAPI, "cli", 3);
	}

	/**
	 * Loads types defined in the specified directory.
	 * 
	 * @param string $pathToLib
	 * 
	 * @return void
	 */
	public static function loadLib ($pathToLib) {
		$absolutePath = realpath($pathToLib);
		if ($absolutePath === false) {
			throw Exception::thrown("Failed to read path: " . ($pathToLib??'null'));
		}
		$collection = glob("" . ($absolutePath??'null') . "/*.php");
		foreach ($collection as $key => $value) {
			if (!is_dir($value)) {
				require_once($value);
			}
		}
		$collection = glob("" . ($absolutePath??'null') . "/*", GLOB_ONLYDIR);
		foreach ($collection as $key => $value) {
			Lib::loadLib($value);
		}
	}

	/**
	 * See the documentation for the equivalent PHP function for details on usage:
	 * <http://php.net/manual/en/function.mail.php>
	 * 
	 * @param string $to
	 * @param string $subject
	 * @param string $message
	 * @param string $additionalHeaders
	 * @param string $additionalParameters
	 * 
	 * @return bool
	 */
	public static function mail ($to, $subject, $message, $additionalHeaders = null, $additionalParameters = null) {
		return mail($to, $subject, $message, $additionalHeaders, $additionalParameters);
	}

	/**
	 * @param mixed $arr
	 * 
	 * @return mixed
	 */
	public static function objectOfAssociativeArray ($arr) {
		foreach ($arr as $key => $value) {
			if (is_array($value)) {
				$arr[$key] = Lib::objectOfAssociativeArray($value);
			}
		}
		return new HxAnon($arr);
	}

	/**
	 * Print the specified value on the default output.
	 * 
	 * @param mixed $v
	 * 
	 * @return void
	 */
	public static function print ($v) {
		echo(\Std::string($v));
	}

	/**
	 * Output file content from the given file name.
	 * 
	 * @param string $file
	 * 
	 * @return int
	 */
	public static function printFile ($file) {
		return fpassthru(fopen($file, "r"));
	}

	/**
	 * Print the specified value on the default output followed by
	 * a newline character.
	 * 
	 * @param mixed $v
	 * 
	 * @return void
	 */
	public static function println ($v) {
		echo(\Std::string($v));
		echo("\x0A");
	}

	/**
	 * Serialize using native PHP serialization. This will return a binary
	 * `String` that can be stored for long term usage.
	 * 
	 * @param mixed $v
	 * 
	 * @return string
	 */
	public static function serialize ($v) {
		return serialize($v);
	}

	/**
	 * @param mixed $a
	 * 
	 * @return \Array_hx
	 */
	public static function toHaxeArray ($a) {
		return \Array_hx::wrap($a);
	}

	/**
	 * @param \Array_hx $a
	 * 
	 * @return mixed
	 */
	public static function toPhpArray ($a) {
		return $a->arr;
	}

	/**
	 * Unserialize a `String` using native PHP serialization. See `php.Lib.serialize()`.
	 * 
	 * @param string $s
	 * 
	 * @return mixed
	 */
	public static function unserialize ($s) {
		return unserialize($s);
	}
}

Boot::registerClass(Lib::class, 'php.Lib');
