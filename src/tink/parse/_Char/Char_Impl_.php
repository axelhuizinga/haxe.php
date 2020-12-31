<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace tink\parse\_Char;

use \php\Boot;
use \php\_Boot\HxString;
use \haxe\ds\IntMap;
use \haxe\ds\StringMap;
use \haxe\ds\_Vector\PhpVectorData;

final class Char_Impl_ {
	/**
	 * @var PhpVectorData
	 */
	static public $CARRIAGE;
	/**
	 * @var PhpVectorData
	 */
	static public $DIGIT;
	/**
	 * @var PhpVectorData
	 */
	static public $LINEBREAK;
	/**
	 * @var PhpVectorData
	 */
	static public $LINEFEED;
	/**
	 * @var PhpVectorData
	 */
	static public $LOWER;
	/**
	 * @var PhpVectorData
	 */
	static public $UPPER;
	/**
	 * @var PhpVectorData
	 */
	static public $WHITE;
	/**
	 * @var IntMap
	 */
	static public $byInt;
	/**
	 * @var StringMap
	 */
	static public $byString;

	/**
	 * @param PhpVectorData $c
	 * 
	 * @return PhpVectorData
	 */
	public static function Char ($c) {
		return $c;
	}

	/**
	 * @param PhpVectorData $a
	 * @param PhpVectorData $b
	 * 
	 * @return PhpVectorData
	 */
	public static function and ($a, $b) {
		$ret = new PhpVectorData(256);
		$_g = 0;
		$_g1 = $ret->length;
		while ($_g < $_g1) {
			$c = $_g++;
			$val = ($a->data[$c] ?? null) && ($b->data[$c] ?? null);
			$ret->data[$c] = $val;
		}
		return $ret;
	}

	/**
	 * @param string $s
	 * 
	 * @return PhpVectorData
	 */
	public static function fromString ($s) {
		$_g = (Char_Impl_::$byString->data[$s] ?? null);
		if ($_g === null) {
			$this1 = Char_Impl_::$byString;
			$ret = new PhpVectorData(256);
			$_g1 = 0;
			$_g2 = mb_strlen($s);
			while ($_g1 < $_g2) {
				$ret->data[HxString::charCodeAt($s, $_g1++)] = true;
			}
			$v = $ret;
			$this1->data[$s] = $v;
			return $v;
		} else {
			return $_g;
		}
	}

	/**
	 * @param PhpVectorData $this
	 * @param int $char
	 * 
	 * @return bool
	 */
	public static function matches ($this1, $char) {
		return ($this1->data[$char] ?? null);
	}

	/**
	 * @param PhpVectorData $a
	 * 
	 * @return PhpVectorData
	 */
	public static function not ($a) {
		$ret = new PhpVectorData(256);
		$_g = 0;
		$_g1 = $ret->length;
		while ($_g < $_g1) {
			$c = $_g++;
			$val = !($a->data[$c] ?? null);
			$ret->data[$c] = $val;
		}
		return $ret;
	}

	/**
	 * @param int $c
	 * 
	 * @return PhpVectorData
	 */
	public static function ofCode ($c) {
		$_g = (Char_Impl_::$byInt->data[$c] ?? null);
		if ($_g === null) {
			$this1 = Char_Impl_::$byInt;
			$ret = new PhpVectorData(256);
			$ret->data[$c] = true;
			$v = $ret;
			$this1->data[$c] = $v;
			return $v;
		} else {
			return $_g;
		}
	}

	/**
	 * @param \Closure $p
	 * 
	 * @return PhpVectorData
	 */
	public static function ofPredicate ($p) {
		$ret = new PhpVectorData(256);
		$_g = 0;
		$_g1 = $ret->length;
		while ($_g < $_g1) {
			$c = $_g++;
			$val = $p($c);
			$ret->data[$c] = $val;
		}
		return $ret;
	}

	/**
	 * @param \IntIterator $i
	 * 
	 * @return PhpVectorData
	 */
	public static function ofRange ($i) {
		$ret = new PhpVectorData(256);
		if ($i->max > 256) {
			$i = new \IntIterator($i->min, 256);
		}
		$_g = $i;
		while ($_g->min < $_g->max) {
			$ret->data[$_g->min++] = true;
		}
		return $ret;
	}

	/**
	 * @param \Array_hx $chars
	 * 
	 * @return PhpVectorData
	 */
	public static function oneOf ($chars) {
		$ret = new PhpVectorData(256);
		$_g = 0;
		while ($_g < $chars->length) {
			$ret->data[$chars[$_g++]] = true;
		}
		return $ret;
	}

	/**
	 * @param PhpVectorData $a
	 * @param PhpVectorData $b
	 * 
	 * @return PhpVectorData
	 */
	public static function or ($a, $b) {
		$ret = new PhpVectorData(256);
		$_g = 0;
		$_g1 = $ret->length;
		while ($_g < $_g1) {
			$c = $_g++;
			$val = ($a->data[$c] ?? null) || ($b->data[$c] ?? null);
			$ret->data[$c] = $val;
		}
		return $ret;
	}

	/**
	 * @param PhpVectorData $a
	 * @param int $b
	 * 
	 * @return PhpVectorData
	 */
	public static function orCode ($a, $b) {
		$b1 = Char_Impl_::ofCode($b);
		$ret = new PhpVectorData(256);
		$_g = 0;
		$_g1 = $ret->length;
		while ($_g < $_g1) {
			$c = $_g++;
			$val = ($a->data[$c] ?? null) || ($b1->data[$c] ?? null);
			$ret->data[$c] = $val;
		}
		return $ret;
	}

	/**
	 * @param PhpVectorData $a
	 * @param string $s
	 * 
	 * @return PhpVectorData
	 */
	public static function orString ($a, $s) {
		$b = Char_Impl_::fromString($s);
		$ret = new PhpVectorData(256);
		$_g = 0;
		$_g1 = $ret->length;
		while ($_g < $_g1) {
			$c = $_g++;
			$val = ($a->data[$c] ?? null) || ($b->data[$c] ?? null);
			$ret->data[$c] = $val;
		}
		return $ret;
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


		self::$byInt = new IntMap();
		self::$byString = new StringMap();
		self::$WHITE = Char_Impl_::oneOf(\Array_hx::wrap([
			9,
			10,
			11,
			12,
			13,
			32,
		]));
		self::$LOWER = Char_Impl_::ofRange(new \IntIterator(97, 123));
		self::$UPPER = Char_Impl_::ofRange(new \IntIterator(65, 91));
		self::$DIGIT = Char_Impl_::ofRange(new \IntIterator(48, 58));
		self::$LINEFEED = Char_Impl_::ofCode(10);
		self::$CARRIAGE = Char_Impl_::ofCode(13);
		$a = Char_Impl_::$LINEFEED;
		$b = Char_Impl_::$CARRIAGE;
		$ret = new PhpVectorData(256);
		{
			$_g = 0;
			$_g1 = $ret->length;
			while ($_g < $_g1) {
				$c = $_g++;
				$val = ($a->data[$c] ?? null) || ($b->data[$c] ?? null);
				$ret->data[$c] = $val;
			}
		};
		self::$LINEBREAK = $ret;
	}
}

Boot::registerClass(Char_Impl_::class, 'tink.parse._Char.Char_Impl_');
Char_Impl_::__hx__init();
