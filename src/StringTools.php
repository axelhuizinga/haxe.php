<?php
/**
 * Generated by Haxe 4.1.5
 */

use \php\Boot;
use \haxe\iterators\StringIterator;
use \php\_Boot\HxString;
use \haxe\iterators\StringKeyValueIterator;
use \haxe\SysTools;

/**
 * This class provides advanced methods on Strings. It is ideally used with
 * `using StringTools` and then acts as an [extension](https://haxe.org/manual/lf-static-extension.html)
 * to the `String` class.
 * If the first argument to any of the methods is null, the result is
 * unspecified.
 */
class StringTools {
	/**
	 * @var \Array_hx
	 * Character codes of the characters that will be escaped by `quoteWinArg(_, true)`.
	 */
	static public $winMetaCharacters;

	/**
	 * Returns `true` if `s` contains `value` and  `false` otherwise.
	 * When `value` is `null`, the result is unspecified.
	 * 
	 * @param string $s
	 * @param string $value
	 * 
	 * @return bool
	 */
	public static function contains ($s, $value) {
		return HxString::indexOf($s, $value) !== -1;
	}

	/**
	 * Tells if the string `s` ends with the string `end`.
	 * If `end` is `null`, the result is unspecified.
	 * If `end` is the empty String `""`, the result is true.
	 * 
	 * @param string $s
	 * @param string $end
	 * 
	 * @return bool
	 */
	public static function endsWith ($s, $end) {
		if ($end !== "") {
			return substr($s, -strlen($end)) === $end;
		} else {
			return true;
		}
	}

	/**
	 * Returns the character code at position `index` of String `s`, or an
	 * end-of-file indicator at if `position` equals `s.length`.
	 * This method is faster than `String.charCodeAt()` on some platforms, but
	 * the result is unspecified if `index` is negative or greater than
	 * `s.length`.
	 * End of file status can be checked by calling `StringTools.isEof()` with
	 * the returned value as argument.
	 * This operation is not guaranteed to work if `s` contains the `\0`
	 * character.
	 * 
	 * @param string $s
	 * @param int $index
	 * 
	 * @return int
	 */
	public static function fastCodeAt ($s, $index) {
		$char = ($index === 0 ? $s : mb_substr($s, $index, 1));
		if ($char === "") {
			return 0;
		}
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

	/**
	 * Encodes `n` into a hexadecimal representation.
	 * If `digits` is specified, the resulting String is padded with "0" until
	 * its `length` equals `digits`.
	 * 
	 * @param int $n
	 * @param int $digits
	 * 
	 * @return string
	 */
	public static function hex ($n, $digits = null) {
		$s = dechex($n);
		$len = 8;
		$tmp = strlen($s);
		$tmp1 = null;
		if (null === $digits) {
			$tmp1 = 8;
		} else {
			$len = ($digits > 8 ? $digits : 8);
			$tmp1 = $len;
		}
		if ($tmp > $tmp1) {
			$s = mb_substr($s, -$len, null);
		} else if ($digits !== null) {
			$s = StringTools::lpad($s, "0", $digits);
		}
		return mb_strtoupper($s);
	}

	/**
	 * Escapes HTML special characters of the string `s`.
	 * The following replacements are made:
	 * - `&` becomes `&amp`;
	 * - `<` becomes `&lt`;
	 * - `>` becomes `&gt`;
	 * If `quotes` is true, the following characters are also replaced:
	 * - `"` becomes `&quot`;
	 * - `'` becomes `&#039`;
	 * 
	 * @param string $s
	 * @param bool $quotes
	 * 
	 * @return string
	 */
	public static function htmlEscape ($s, $quotes = null) {
		return htmlspecialchars($s, ($quotes ? ENT_QUOTES | ENT_HTML401 : ENT_NOQUOTES));
	}

	/**
	 * Unescapes HTML special characters of the string `s`.
	 * This is the inverse operation to htmlEscape, i.e. the following always
	 * holds: `htmlUnescape(htmlEscape(s)) == s`
	 * The replacements follow:
	 * - `&amp;` becomes `&`
	 * - `&lt;` becomes `<`
	 * - `&gt;` becomes `>`
	 * - `&quot;` becomes `"`
	 * - `&#039;` becomes `'`
	 * 
	 * @param string $s
	 * 
	 * @return string
	 */
	public static function htmlUnescape ($s) {
		return htmlspecialchars_decode($s, ENT_QUOTES);
	}

	/**
	 * Tells if `c` represents the end-of-file (EOF) character.
	 * 
	 * @param int $c
	 * 
	 * @return bool
	 */
	public static function isEof ($c) {
		return $c === 0;
	}

	/**
	 * Tells if the character in the string `s` at position `pos` is a space.
	 * A character is considered to be a space character if its character code
	 * is 9,10,11,12,13 or 32.
	 * If `s` is the empty String `""`, or if pos is not a valid position within
	 * `s`, the result is false.
	 * 
	 * @param string $s
	 * @param int $pos
	 * 
	 * @return bool
	 */
	public static function isSpace ($s, $pos) {
		$c = HxString::charCodeAt($s, $pos);
		if (!(($c >= 9) && ($c <= 13))) {
			return $c === 32;
		} else {
			return true;
		}
	}

	/**
	 * Returns an iterator of the char codes.
	 * Note that char codes may differ across platforms because of different
	 * internal encoding of strings in different runtimes.
	 * For the consistent cross-platform UTF8 char codes see `haxe.iterators.StringIteratorUnicode`.
	 * 
	 * @param string $s
	 * 
	 * @return StringIterator
	 */
	public static function iterator ($s) {
		return new StringIterator($s);
	}

	/**
	 * Returns an iterator of the char indexes and codes.
	 * Note that char codes may differ across platforms because of different
	 * internal encoding of strings in different of runtimes.
	 * For the consistent cross-platform UTF8 char codes see `haxe.iterators.StringKeyValueIteratorUnicode`.
	 * 
	 * @param string $s
	 * 
	 * @return StringKeyValueIterator
	 */
	public static function keyValueIterator ($s) {
		return new StringKeyValueIterator($s);
	}

	/**
	 * Concatenates `c` to `s` until `s.length` is at least `l`.
	 * If `c` is the empty String `""` or if `l` does not exceed `s.length`,
	 * `s` is returned unchanged.
	 * If `c.length` is 1, the resulting String length is exactly `l`.
	 * Otherwise the length may exceed `l`.
	 * If `c` is null, the result is unspecified.
	 * 
	 * @param string $s
	 * @param string $c
	 * @param int $l
	 * 
	 * @return string
	 */
	public static function lpad ($s, $c, $l) {
		$cLength = mb_strlen($c);
		$sLength = mb_strlen($s);
		if (($cLength === 0) || ($sLength >= $l)) {
			return $s;
		}
		$padLength = $l - $sLength;
		$padCount = (int)(($padLength / $cLength));
		if ($padCount > 0) {
			$result = str_pad($s, strlen($s) + $padCount * strlen($c), $c, STR_PAD_LEFT);
			if (($padCount * $cLength) >= $padLength) {
				return $result;
			} else {
				return ($c . $result);
			}
		} else {
			return ($c . $s);
		}
	}

	/**
	 * Removes leading space characters of `s`.
	 * This function internally calls `isSpace()` to decide which characters to
	 * remove.
	 * If `s` is the empty String `""` or consists only of space characters, the
	 * result is the empty String `""`.
	 * 
	 * @param string $s
	 * 
	 * @return string
	 */
	public static function ltrim ($s) {
		return ltrim($s);
	}

	/**
	 * Returns a String that can be used as a single command line argument
	 * on Unix.
	 * The input will be quoted, or escaped if necessary.
	 * 
	 * @param string $argument
	 * 
	 * @return string
	 */
	public static function quoteUnixArg ($argument) {
		if ($argument === "") {
			return "''";
		} else if (!(new \EReg("[^a-zA-Z0-9_@%+=:,./-]", ""))->match($argument)) {
			return $argument;
		} else {
			return "'" . (StringTools::replace($argument, "'", "'\"'\"'")??'null') . "'";
		}
	}

	/**
	 * Returns a String that can be used as a single command line argument
	 * on Windows.
	 * The input will be quoted, or escaped if necessary, such that the output
	 * will be parsed as a single argument using the rule specified in
	 * http://msdn.microsoft.com/en-us/library/ms880421
	 * Examples:
	 * ```haxe
	 * quoteWinArg("abc") == "abc";
	 * quoteWinArg("ab c") == '"ab c"';
	 * ```
	 * 
	 * @param string $argument
	 * @param bool $escapeMetaCharacters
	 * 
	 * @return string
	 */
	public static function quoteWinArg ($argument, $escapeMetaCharacters) {
		$argument1 = $argument;
		if (!(new \EReg("^[^ \x09\\\\\"]+\$", ""))->match($argument)) {
			$result = new \StringBuf();
			$needquote = (HxString::indexOf($argument, " ") !== -1) || (HxString::indexOf($argument, "\x09") !== -1) || ($argument === "");
			if ($needquote) {
				$result->add("\"");
			}
			$bs_buf = new \StringBuf();
			$_g = 0;
			$_g1 = mb_strlen($argument);
			while ($_g < $_g1) {
				$_g2 = HxString::charCodeAt($argument, $_g++);
				if ($_g2 === null) {
					if (mb_strlen($bs_buf->b) > 0) {
						$result->add($bs_buf->b);
						$bs_buf = new \StringBuf();
					}
					$result->b = ($result->b??'null') . (mb_chr($_g2)??'null');
				} else {
					if ($_g2 === 34) {
						$bs = $bs_buf->b;
						$result->add($bs);
						$result->add($bs);
						$bs_buf = new \StringBuf();
						$result->add("\\\"");
					} else if ($_g2 === 92) {
						$bs_buf->add("\\");
					} else {
						if (mb_strlen($bs_buf->b) > 0) {
							$result->add($bs_buf->b);
							$bs_buf = new \StringBuf();
						}
						$result->b = ($result->b??'null') . (mb_chr($_g2)??'null');
					}
				}
			}
			$result->add($bs_buf->b);
			if ($needquote) {
				$result->add($bs_buf->b);
				$result->add("\"");
			}
			$argument1 = $result->b;
		}
		if ($escapeMetaCharacters) {
			$result = new \StringBuf();
			$_g = 0;
			$_g1 = mb_strlen($argument1);
			while ($_g < $_g1) {
				$c = HxString::charCodeAt($argument1, $_g++);
				if (SysTools::$winMetaCharacters->indexOf($c) >= 0) {
					$result->b = ($result->b??'null') . (mb_chr(94)??'null');
				}
				$result->b = ($result->b??'null') . (mb_chr($c)??'null');
			}
			return $result->b;
		} else {
			return $argument1;
		}
	}

	/**
	 * Replace all occurrences of the String `sub` in the String `s` by the
	 * String `by`.
	 * If `sub` is the empty String `""`, `by` is inserted after each character
	 * of `s` except the last one. If `by` is also the empty String `""`, `s`
	 * remains unchanged.
	 * If `sub` or `by` are null, the result is unspecified.
	 * 
	 * @param string $s
	 * @param string $sub
	 * @param string $by
	 * 
	 * @return string
	 */
	public static function replace ($s, $sub, $by) {
		if ($sub === "") {
			return implode($by, preg_split("//u", $s, -1, PREG_SPLIT_NO_EMPTY));
		}
		return str_replace($sub, $by, $s);
	}

	/**
	 * Appends `c` to `s` until `s.length` is at least `l`.
	 * If `c` is the empty String `""` or if `l` does not exceed `s.length`,
	 * `s` is returned unchanged.
	 * If `c.length` is 1, the resulting String length is exactly `l`.
	 * Otherwise the length may exceed `l`.
	 * If `c` is null, the result is unspecified.
	 * 
	 * @param string $s
	 * @param string $c
	 * @param int $l
	 * 
	 * @return string
	 */
	public static function rpad ($s, $c, $l) {
		$cLength = mb_strlen($c);
		$sLength = mb_strlen($s);
		if (($cLength === 0) || ($sLength >= $l)) {
			return $s;
		}
		$padLength = $l - $sLength;
		$padCount = (int)(($padLength / $cLength));
		if ($padCount > 0) {
			$result = str_pad($s, strlen($s) + $padCount * strlen($c), $c, STR_PAD_RIGHT);
			if (($padCount * $cLength) >= $padLength) {
				return $result;
			} else {
				return ($result . $c);
			}
		} else {
			return ($s . $c);
		}
	}

	/**
	 * Removes trailing space characters of `s`.
	 * This function internally calls `isSpace()` to decide which characters to
	 * remove.
	 * If `s` is the empty String `""` or consists only of space characters, the
	 * result is the empty String `""`.
	 * 
	 * @param string $s
	 * 
	 * @return string
	 */
	public static function rtrim ($s) {
		return rtrim($s);
	}

	/**
	 * Tells if the string `s` starts with the string `start`.
	 * If `start` is `null`, the result is unspecified.
	 * If `start` is the empty String `""`, the result is true.
	 * 
	 * @param string $s
	 * @param string $start
	 * 
	 * @return bool
	 */
	public static function startsWith ($s, $start) {
		if ($start !== "") {
			return substr($s, 0, strlen($start)) === $start;
		} else {
			return true;
		}
	}

	/**
	 * Removes leading and trailing space characters of `s`.
	 * This is a convenience function for `ltrim(rtrim(s))`.
	 * 
	 * @param string $s
	 * 
	 * @return string
	 */
	public static function trim ($s) {
		return trim($s);
	}

	/**
	 * Decode an URL using the standard format.
	 * 
	 * @param string $s
	 * 
	 * @return string
	 */
	public static function urlDecode ($s) {
		return urldecode($s);
	}

	/**
	 * Encode an URL by using the standard format.
	 * 
	 * @param string $s
	 * 
	 * @return string
	 */
	public static function urlEncode ($s) {
		return rawurlencode($s);
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


		self::$winMetaCharacters = SysTools::$winMetaCharacters;
	}
}

Boot::registerClass(StringTools::class, 'StringTools');
StringTools::__hx__init();
