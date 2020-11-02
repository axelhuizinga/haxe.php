<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace haxe\zip;

use \php\Boot;
use \haxe\io\Bytes;
use \php\_Boot\HxEnum;

class ExtraField extends HxEnum {
	/**
	 * @param string $name
	 * @param int $crc
	 * 
	 * @return ExtraField
	 */
	static public function FInfoZipUnicodePath ($name, $crc) {
		return new ExtraField('FInfoZipUnicodePath', 1, [$name, $crc]);
	}

	/**
	 * @param int $tag
	 * @param Bytes $bytes
	 * 
	 * @return ExtraField
	 */
	static public function FUnknown ($tag, $bytes) {
		return new ExtraField('FUnknown', 0, [$tag, $bytes]);
	}

	/**
	 * @return ExtraField
	 */
	static public function FUtf8 () {
		static $inst = null;
		if (!$inst) $inst = new ExtraField('FUtf8', 2, []);
		return $inst;
	}

	/**
	 * Returns array of (constructorIndex => constructorName)
	 *
	 * @return string[]
	 */
	static public function __hx__list () {
		return [
			1 => 'FInfoZipUnicodePath',
			0 => 'FUnknown',
			2 => 'FUtf8',
		];
	}

	/**
	 * Returns array of (constructorName => parametersCount)
	 *
	 * @return int[]
	 */
	static public function __hx__paramsCount () {
		return [
			'FInfoZipUnicodePath' => 2,
			'FUnknown' => 2,
			'FUtf8' => 0,
		];
	}
}

Boot::registerClass(ExtraField::class, 'haxe.zip.ExtraField');
