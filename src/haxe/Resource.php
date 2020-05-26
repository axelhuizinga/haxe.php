<?php
/**
 * Generated by Haxe 4.1.1
 */

namespace haxe;

use \php\Boot;
use \sys\io\File;
use \sys\FileSystem;
use \haxe\io\Bytes;
use \haxe\io\Path;

/**
 * Resource can be used to access resources that were added through the
 * `--resource file@name` command line parameter.
 * Depending on their type they can be obtained as `String` through
 * `getString(name)`, or as binary data through `getBytes(name)`.
 * A list of all available resource names can be obtained from `listNames()`.
 */
class Resource {
	/**
	 * @param string $name
	 * 
	 * @return string
	 */
	public static function cleanName ($name) {
		return (new \EReg("[\\\\/:?\"*<>|]", ""))->replace($name, "_");
	}

	/**
	 * Retrieves the resource identified by `name` as an instance of
	 * haxe.io.Bytes.
	 * If `name` does not match any resource name, `null` is returned.
	 * 
	 * @param string $name
	 * 
	 * @return Bytes
	 */
	public static function getBytes ($name) {
		$path = Resource::getPath($name);
		clearstatcache(true, $path);
		if (!file_exists($path)) {
			return null;
		} else {
			return File::getBytes($path);
		}
	}

	/**
	 * @return string
	 */
	public static function getDir () {
		return (dirname(__FILE__)??'null') . "/../.." . "/res";
	}

	/**
	 * @param string $name
	 * 
	 * @return string
	 */
	public static function getPath ($name) {
		return (Resource::getDir()??'null') . "/" . (Path::escape($name)??'null');
	}

	/**
	 * Retrieves the resource identified by `name` as a `String`.
	 * If `name` does not match any resource name, `null` is returned.
	 * 
	 * @param string $name
	 * 
	 * @return string
	 */
	public static function getString ($name) {
		$path = Resource::getPath($name);
		clearstatcache(true, $path);
		if (!file_exists($path)) {
			return null;
		} else {
			return File::getContent($path);
		}
	}

	/**
	 * Lists all available resource names. The resource name is the name part
	 * of the `--resource file@name` command line parameter.
	 * 
	 * @return \Array_hx
	 */
	public static function listNames () {
		$a = FileSystem::readDirectory(Resource::getDir());
		if (($a->arr[0] ?? null) === ".") {
			if ($a->length > 0) {
				$a->length--;
			}
			array_shift($a->arr);
		}
		if (($a->arr[0] ?? null) === "..") {
			if ($a->length > 0) {
				$a->length--;
			}
			array_shift($a->arr);
		}
		$result = [];
		$data = $a->arr;
		$_g_current = 0;
		$_g_length = count($data);
		while ($_g_current < $_g_length) {
			$result[] = Path::unescape($data[$_g_current++]);
		}
		return \Array_hx::wrap($result);
	}
}

Boot::registerClass(Resource::class, 'haxe.Resource');
