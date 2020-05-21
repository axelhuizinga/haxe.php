<?php
/**
 * Generated by Haxe 4.1.0
 */

namespace php\_Boot;

use \php\Boot;

/**
 * `String` implementation
 */
class HxString {
	/**
	 * @param string $str
	 * @param int $index
	 * 
	 * @return string
	 */
	public static function charAt ($str, $index) {
		if ($index < 0) {
			return "";
		} else {
			return mb_substr($str, $index, 1);
		}
	}

	/**
	 * @param string $str
	 * @param int $index
	 * 
	 * @return int
	 */
	public static function charCodeAt ($str, $index) {
		if (($index < 0) || ($str === "")) {
			return null;
		}
		if ($index === 0) {
			$code = ord($str[0]);
			if ($code < 192) {
				return $code;
			} else if ($code < 224) {
				return (($code - 192) << 6) + ord($str[1]) - 128;
			} else if ($code < 240) {
				return (($code - 224) << 12) + ((ord($str[1]) - 128) << 6) + ord($str[2]) - 128;
			} else {
				return (($code - 240) << 18) + ((ord($str[1]) - 128) << 12) + ((ord($str[2]) - 128) << 6) + ord($str[3]) - 128;
			}
		}
		$char = mb_substr($str, $index, 1);
		if ($char === "") {
			return null;
		} else {
			$code = ord($char[0]);
			if ($code < 192) {
				return $code;
			} else if ($code < 224) {
				return (($code - 192) << 6) + ord($char[1]) - 128;
			} else if ($code < 240) {
				return (($code - 224) << 12) + ((ord($char[1]) - 128) << 6) + ord($char[2]) - 128;
			} else {
				return (($code - 240) << 18) + ((ord($char[1]) - 128) << 12) + ((ord($char[2]) - 128) << 6) + ord($char[3]) - 128;
			}
		}
	}

	/**
	 * @param int $code
	 * 
	 * @return string
	 */
	public static function fromCharCode ($code) {
		return mb_chr($code);
	}

	/**
	 * @param string $str
	 * @param string $search
	 * @param int $startIndex
	 * 
	 * @return int
	 */
	public static function indexOf ($str, $search, $startIndex = null) {
		if ($startIndex === null) {
			$startIndex = 0;
		} else {
			$length = mb_strlen($str);
			if ($startIndex < 0) {
				$startIndex += $length;
				if ($startIndex < 0) {
					$startIndex = 0;
				}
			}
			if (($startIndex >= $length) && ($search !== "")) {
				return -1;
			}
		}
		$index = null;
		if ($search === "") {
			$length = mb_strlen($str);
			$index = ($startIndex > $length ? $length : $startIndex);
		} else {
			$index = mb_strpos($str, $search, $startIndex);
		}
		if ($index === false) {
			return -1;
		} else {
			return $index;
		}
	}

	/**
	 * @param string $str
	 * @param string $search
	 * @param int $startIndex
	 * 
	 * @return int
	 */
	public static function lastIndexOf ($str, $search, $startIndex = null) {
		$start = $startIndex;
		if ($startIndex === null) {
			$start = 0;
		} else {
			$length = mb_strlen($str);
			if ($startIndex >= 0) {
				$start = $startIndex - $length;
				if ($start > 0) {
					$start = 0;
				}
			} else if ($startIndex < -$length) {
				$start = -$length;
			}
		}
		$index = null;
		if ($search === "") {
			$length = mb_strlen($str);
			$index = (($startIndex === null) || ($startIndex > $length) ? $length : $startIndex);
		} else {
			$index = mb_strrpos($str, $search, $start);
		}
		if ($index === false) {
			return -1;
		} else {
			return $index;
		}
	}

	/**
	 * @param string $str
	 * @param string $delimiter
	 * 
	 * @return \Array_hx
	 */
	public static function split ($str, $delimiter) {
		$arr = null;
		if ($delimiter === "") {
			$arr = preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);
		} else {
			$delimiter = preg_quote($delimiter, "/");
			$arr = preg_split("/" . ($delimiter??'null') . "/", $str);
		}
		return \Array_hx::wrap($arr);
	}

	/**
	 * @param string $str
	 * @param int $pos
	 * @param int $len
	 * 
	 * @return string
	 */
	public static function substr ($str, $pos, $len = null) {
		return mb_substr($str, $pos, $len);
	}

	/**
	 * @param string $str
	 * @param int $startIndex
	 * @param int $endIndex
	 * 
	 * @return string
	 */
	public static function substring ($str, $startIndex, $endIndex = null) {
		if ($endIndex === null) {
			if ($startIndex < 0) {
				$startIndex = 0;
			}
			return mb_substr($str, $startIndex);
		}
		if ($endIndex < 0) {
			$endIndex = 0;
		}
		if ($startIndex < 0) {
			$startIndex = 0;
		}
		if ($startIndex > $endIndex) {
			$tmp = $endIndex;
			$endIndex = $startIndex;
			$startIndex = $tmp;
		}
		return mb_substr($str, $startIndex, $endIndex - $startIndex);
	}

	/**
	 * @param string $str
	 * 
	 * @return string
	 */
	public static function toLowerCase ($str) {
		return mb_strtolower($str);
	}

	/**
	 * @param string $str
	 * 
	 * @return string
	 */
	public static function toString ($str) {
		return $str;
	}

	/**
	 * @param string $str
	 * 
	 * @return string
	 */
	public static function toUpperCase ($str) {
		return mb_strtoupper($str);
	}
}

Boot::registerClass(HxString::class, 'php._Boot.HxString');
