<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace haxe\_Int64;

use \php\_Boot\HxAnon;
use \php\Boot;
use \haxe\Exception;
use \haxe\Int64Helper;
use \haxe\_Int32\Int32_Impl_;

final class Int64_Impl_ {

	/**
	 * @param ___Int64 $x
	 * 
	 * @return ___Int64
	 */
	public static function _new ($x) {
		return $x;
	}

	/**
	 * Returns the sum of `a` and `b`.
	 * 
	 * @param ___Int64 $a
	 * @param ___Int64 $b
	 * 
	 * @return ___Int64
	 */
	public static function add ($a, $b) {
		$high = (($a->high + $b->high) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		$low = (($a->low + $b->low) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		if (Int32_Impl_::ucompare($low, $a->low) < 0) {
			++$high;
			$high = ($high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		}
		return new ___Int64($high, $low);
	}

	/**
	 * @param ___Int64 $a
	 * @param int $b
	 * 
	 * @return ___Int64
	 */
	public static function addInt ($a, $b) {
		$high = (($a->high + ($b >> 31)) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		$low = (($a->low + $b) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		if (Int32_Impl_::ucompare($low, $a->low) < 0) {
			++$high;
			$high = ($high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		}
		return new ___Int64($high, $low);
	}

	/**
	 * Returns the bitwise AND of `a` and `b`.
	 * 
	 * @param ___Int64 $a
	 * @param ___Int64 $b
	 * 
	 * @return ___Int64
	 */
	public static function and ($a, $b) {
		return new ___Int64($a->high & $b->high, $a->low & $b->low);
	}

	/**
	 * Compares `a` and `b` in signed mode.
	 * Returns a negative value if `a < b`, positive if `a > b`,
	 * or 0 if `a == b`.
	 * 
	 * @param ___Int64 $a
	 * @param ___Int64 $b
	 * 
	 * @return int
	 */
	public static function compare ($a, $b) {
		$v = (($a->high - $b->high) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		if ($v === 0) {
			$v = Int32_Impl_::ucompare($a->low, $b->low);
		}
		if ($a->high < 0) {
			if ($b->high < 0) {
				return $v;
			} else {
				return -1;
			}
		} else if ($b->high >= 0) {
			return $v;
		} else {
			return 1;
		}
	}

	/**
	 * Returns the bitwise NOT of `a`.
	 * 
	 * @param ___Int64 $a
	 * 
	 * @return ___Int64
	 */
	public static function complement ($a) {
		return new ___Int64((~$a->high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits, (~$a->low << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits);
	}

	/**
	 * Makes a copy of `this` Int64.
	 * 
	 * @param ___Int64 $this
	 * 
	 * @return ___Int64
	 */
	public static function copy ($this1) {
		return new ___Int64($this1->high, $this1->low);
	}

	/**
	 * Returns the quotient of `a` divided by `b`.
	 * 
	 * @param ___Int64 $a
	 * @param ___Int64 $b
	 * 
	 * @return ___Int64
	 */
	public static function div ($a, $b) {
		return Int64_Impl_::divMod($a, $b)->quotient;
	}

	/**
	 * @param ___Int64 $a
	 * @param int $b
	 * 
	 * @return ___Int64
	 */
	public static function divInt ($a, $b) {
		return Int64_Impl_::divMod($a, new ___Int64($b >> 31, $b))->quotient;
	}

	/**
	 * Performs signed integer divison of `dividend` by `divisor`.
	 * Returns `{ quotient : Int64, modulus : Int64 }`.
	 * 
	 * @param ___Int64 $dividend
	 * @param ___Int64 $divisor
	 * 
	 * @return object
	 */
	public static function divMod ($dividend, $divisor) {
		if ($divisor->high === 0) {
			$__hx__switch = ($divisor->low);
			if ($__hx__switch === 0) {
				throw Exception::thrown("divide by zero");
			} else if ($__hx__switch === 1) {
				return new HxAnon([
					"quotient" => new ___Int64($dividend->high, $dividend->low),
					"modulus" => new ___Int64(0, 0),
				]);
			}
		}
		$divSign = ($dividend->high < 0) !== ($divisor->high < 0);
		$modulus = null;
		if ($dividend->high < 0) {
			$high = (~$dividend->high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
			$low = ((~$dividend->low + 1) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
			if ($low === 0) {
				++$high;
				$high = ($high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
			}
			$modulus = new ___Int64($high, $low);
		} else {
			$modulus = new ___Int64($dividend->high, $dividend->low);
		}
		if ($divisor->high < 0) {
			$high = (~$divisor->high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
			$low = ((~$divisor->low + 1) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
			if ($low === 0) {
				++$high;
				$high = ($high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
			}
			$divisor = new ___Int64($high, $low);
		}
		$quotient = new ___Int64(0, 0);
		$mask = new ___Int64(0, 1);
		while (!($divisor->high < 0)) {
			$v = Int32_Impl_::ucompare($divisor->high, $modulus->high);
			$cmp = ($v !== 0 ? $v : Int32_Impl_::ucompare($divisor->low, $modulus->low));
			$divisor = new ___Int64((((($divisor->high << 1 << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits) | Boot::shiftRightUnsigned($divisor->low, 31)) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits, ($divisor->low << 1 << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits);
			$mask = new ___Int64((((($mask->high << 1 << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits) | Boot::shiftRightUnsigned($mask->low, 31)) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits, ($mask->low << 1 << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits);
			if ($cmp >= 0) {
				break;
			}
		}
		while (($mask->high !== 0) || ($mask->low !== 0)) {
			$v = Int32_Impl_::ucompare($modulus->high, $divisor->high);
			if ((($v !== 0 ? $v : Int32_Impl_::ucompare($modulus->low, $divisor->low))) >= 0) {
				$quotient = new ___Int64((($quotient->high | $mask->high) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits, (($quotient->low | $mask->low) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits);
				$high = (($modulus->high - $divisor->high) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
				if (Int32_Impl_::ucompare($modulus->low, $divisor->low) < 0) {
					--$high;
					$high = ($high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
				}
				$modulus = new ___Int64($high, (($modulus->low - $divisor->low) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits);
			}
			$mask = new ___Int64(Boot::shiftRightUnsigned($mask->high, 1), (((($mask->high << 31 << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits) | Boot::shiftRightUnsigned($mask->low, 1)) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits);
			$divisor = new ___Int64(Boot::shiftRightUnsigned($divisor->high, 1), (((($divisor->high << 31 << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits) | Boot::shiftRightUnsigned($divisor->low, 1)) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits);
		}
		if ($divSign) {
			$high = (~$quotient->high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
			$low = ((~$quotient->low + 1) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
			if ($low === 0) {
				++$high;
				$high = ($high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
			}
			$quotient = new ___Int64($high, $low);
		}
		if ($dividend->high < 0) {
			$high = (~$modulus->high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
			$low = ((~$modulus->low + 1) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
			if ($low === 0) {
				++$high;
				$high = ($high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
			}
			$modulus = new ___Int64($high, $low);
		}
		return new HxAnon([
			"quotient" => $quotient,
			"modulus" => $modulus,
		]);
	}

	/**
	 * Returns `true` if `a` is equal to `b`.
	 * 
	 * @param ___Int64 $a
	 * @param ___Int64 $b
	 * 
	 * @return bool
	 */
	public static function eq ($a, $b) {
		if ($a->high === $b->high) {
			return $a->low === $b->low;
		} else {
			return false;
		}
	}

	/**
	 * @param ___Int64 $a
	 * @param int $b
	 * 
	 * @return bool
	 */
	public static function eqInt ($a, $b) {
		if ($a->high === ($b >> 31)) {
			return $a->low === $b;
		} else {
			return false;
		}
	}

	/**
	 * @param float $f
	 * 
	 * @return ___Int64
	 */
	public static function fromFloat ($f) {
		return Int64Helper::fromFloat($f);
	}

	/**
	 * Returns the high 32-bit word of `x`.
	 * 
	 * @param ___Int64 $x
	 * 
	 * @return int
	 */
	public static function getHigh ($x) {
		return $x->high;
	}

	/**
	 * Returns the low 32-bit word of `x`.
	 * 
	 * @param ___Int64 $x
	 * 
	 * @return int
	 */
	public static function getLow ($x) {
		return $x->low;
	}

	/**
	 * @param ___Int64 $this
	 * 
	 * @return int
	 */
	public static function get_high ($this1) {
		return $this1->high;
	}

	/**
	 * @param ___Int64 $this
	 * 
	 * @return int
	 */
	public static function get_low ($this1) {
		return $this1->low;
	}

	/**
	 * @param ___Int64 $a
	 * @param ___Int64 $b
	 * 
	 * @return bool
	 */
	public static function gt ($a, $b) {
		$v = (($a->high - $b->high) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		if ($v === 0) {
			$v = Int32_Impl_::ucompare($a->low, $b->low);
		}
		return (($a->high < 0 ? ($b->high < 0 ? $v : -1) : ($b->high >= 0 ? $v : 1))) > 0;
	}

	/**
	 * @param ___Int64 $a
	 * @param int $b
	 * 
	 * @return bool
	 */
	public static function gtInt ($a, $b) {
		$b_high = $b >> 31;
		$v = (($a->high - $b_high) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		if ($v === 0) {
			$v = Int32_Impl_::ucompare($a->low, $b);
		}
		return (($a->high < 0 ? ($b_high < 0 ? $v : -1) : ($b_high >= 0 ? $v : 1))) > 0;
	}

	/**
	 * @param ___Int64 $a
	 * @param ___Int64 $b
	 * 
	 * @return bool
	 */
	public static function gte ($a, $b) {
		$v = (($a->high - $b->high) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		if ($v === 0) {
			$v = Int32_Impl_::ucompare($a->low, $b->low);
		}
		return (($a->high < 0 ? ($b->high < 0 ? $v : -1) : ($b->high >= 0 ? $v : 1))) >= 0;
	}

	/**
	 * @param ___Int64 $a
	 * @param int $b
	 * 
	 * @return bool
	 */
	public static function gteInt ($a, $b) {
		$b_high = $b >> 31;
		$v = (($a->high - $b_high) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		if ($v === 0) {
			$v = Int32_Impl_::ucompare($a->low, $b);
		}
		return (($a->high < 0 ? ($b_high < 0 ? $v : -1) : ($b_high >= 0 ? $v : 1))) >= 0;
	}

	/**
	 * @param int $a
	 * @param ___Int64 $b
	 * 
	 * @return ___Int64
	 */
	public static function intDiv ($a, $b) {
		$x = Int64_Impl_::divMod(new ___Int64($a >> 31, $a), $b)->quotient;
		if ($x->high !== ((($x->low >> 31) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits)) {
			throw Exception::thrown("Overflow");
		}
		$x1 = $x->low;
		return new ___Int64($x1 >> 31, $x1);
	}

	/**
	 * @param int $a
	 * @param ___Int64 $b
	 * 
	 * @return bool
	 */
	public static function intGt ($a, $b) {
		$a_high = $a >> 31;
		$v = (($a_high - $b->high) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		if ($v === 0) {
			$v = Int32_Impl_::ucompare($a, $b->low);
		}
		return (($a_high < 0 ? ($b->high < 0 ? $v : -1) : ($b->high >= 0 ? $v : 1))) > 0;
	}

	/**
	 * @param int $a
	 * @param ___Int64 $b
	 * 
	 * @return bool
	 */
	public static function intGte ($a, $b) {
		$a_high = $a >> 31;
		$v = (($a_high - $b->high) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		if ($v === 0) {
			$v = Int32_Impl_::ucompare($a, $b->low);
		}
		return (($a_high < 0 ? ($b->high < 0 ? $v : -1) : ($b->high >= 0 ? $v : 1))) >= 0;
	}

	/**
	 * @param int $a
	 * @param ___Int64 $b
	 * 
	 * @return bool
	 */
	public static function intLt ($a, $b) {
		$a_high = $a >> 31;
		$v = (($a_high - $b->high) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		if ($v === 0) {
			$v = Int32_Impl_::ucompare($a, $b->low);
		}
		return (($a_high < 0 ? ($b->high < 0 ? $v : -1) : ($b->high >= 0 ? $v : 1))) < 0;
	}

	/**
	 * @param int $a
	 * @param ___Int64 $b
	 * 
	 * @return bool
	 */
	public static function intLte ($a, $b) {
		$a_high = $a >> 31;
		$v = (($a_high - $b->high) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		if ($v === 0) {
			$v = Int32_Impl_::ucompare($a, $b->low);
		}
		return (($a_high < 0 ? ($b->high < 0 ? $v : -1) : ($b->high >= 0 ? $v : 1))) <= 0;
	}

	/**
	 * @param int $a
	 * @param ___Int64 $b
	 * 
	 * @return ___Int64
	 */
	public static function intMod ($a, $b) {
		$x = Int64_Impl_::divMod(new ___Int64($a >> 31, $a), $b)->modulus;
		if ($x->high !== ((($x->low >> 31) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits)) {
			throw Exception::thrown("Overflow");
		}
		$x1 = $x->low;
		return new ___Int64($x1 >> 31, $x1);
	}

	/**
	 * @param int $a
	 * @param ___Int64 $b
	 * 
	 * @return ___Int64
	 */
	public static function intSub ($a, $b) {
		$a_low = $a;
		$high = ((($a >> 31) - $b->high) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		if (Int32_Impl_::ucompare($a_low, $b->low) < 0) {
			--$high;
			$high = ($high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		}
		return new ___Int64($high, (($a_low - $b->low) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits);
	}

	/**
	 * @param mixed $val
	 * 
	 * @return bool
	 */
	public static function is ($val) {
		return ($val instanceof ___Int64);
	}

	/**
	 * Returns whether the value `val` is of type `haxe.Int64`
	 * 
	 * @param mixed $val
	 * 
	 * @return bool
	 */
	public static function isInt64 ($val) {
		return ($val instanceof ___Int64);
	}

	/**
	 * Returns `true` if `x` is less than zero.
	 * 
	 * @param ___Int64 $x
	 * 
	 * @return bool
	 */
	public static function isNeg ($x) {
		return $x->high < 0;
	}

	/**
	 * Returns `true` if `x` is exactly zero.
	 * 
	 * @param ___Int64 $x
	 * 
	 * @return bool
	 */
	public static function isZero ($x) {
		if ($x->high === 0) {
			return $x->low === 0;
		} else {
			return false;
		}
	}

	/**
	 * @param ___Int64 $a
	 * @param ___Int64 $b
	 * 
	 * @return bool
	 */
	public static function lt ($a, $b) {
		$v = (($a->high - $b->high) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		if ($v === 0) {
			$v = Int32_Impl_::ucompare($a->low, $b->low);
		}
		return (($a->high < 0 ? ($b->high < 0 ? $v : -1) : ($b->high >= 0 ? $v : 1))) < 0;
	}

	/**
	 * @param ___Int64 $a
	 * @param int $b
	 * 
	 * @return bool
	 */
	public static function ltInt ($a, $b) {
		$b_high = $b >> 31;
		$v = (($a->high - $b_high) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		if ($v === 0) {
			$v = Int32_Impl_::ucompare($a->low, $b);
		}
		return (($a->high < 0 ? ($b_high < 0 ? $v : -1) : ($b_high >= 0 ? $v : 1))) < 0;
	}

	/**
	 * @param ___Int64 $a
	 * @param ___Int64 $b
	 * 
	 * @return bool
	 */
	public static function lte ($a, $b) {
		$v = (($a->high - $b->high) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		if ($v === 0) {
			$v = Int32_Impl_::ucompare($a->low, $b->low);
		}
		return (($a->high < 0 ? ($b->high < 0 ? $v : -1) : ($b->high >= 0 ? $v : 1))) <= 0;
	}

	/**
	 * @param ___Int64 $a
	 * @param int $b
	 * 
	 * @return bool
	 */
	public static function lteInt ($a, $b) {
		$b_high = $b >> 31;
		$v = (($a->high - $b_high) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		if ($v === 0) {
			$v = Int32_Impl_::ucompare($a->low, $b);
		}
		return (($a->high < 0 ? ($b_high < 0 ? $v : -1) : ($b_high >= 0 ? $v : 1))) <= 0;
	}

	/**
	 * Construct an Int64 from two 32-bit words `high` and `low`.
	 * 
	 * @param int $high
	 * @param int $low
	 * 
	 * @return ___Int64
	 */
	public static function make ($high, $low) {
		return new ___Int64($high, $low);
	}

	/**
	 * Returns the modulus of `a` divided by `b`.
	 * 
	 * @param ___Int64 $a
	 * @param ___Int64 $b
	 * 
	 * @return ___Int64
	 */
	public static function mod ($a, $b) {
		return Int64_Impl_::divMod($a, $b)->modulus;
	}

	/**
	 * @param ___Int64 $a
	 * @param int $b
	 * 
	 * @return ___Int64
	 */
	public static function modInt ($a, $b) {
		$x = Int64_Impl_::divMod($a, new ___Int64($b >> 31, $b))->modulus;
		if ($x->high !== ((($x->low >> 31) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits)) {
			throw Exception::thrown("Overflow");
		}
		$x1 = $x->low;
		return new ___Int64($x1 >> 31, $x1);
	}

	/**
	 * Returns the product of `a` and `b`.
	 * 
	 * @param ___Int64 $a
	 * @param ___Int64 $b
	 * 
	 * @return ___Int64
	 */
	public static function mul ($a, $b) {
		$al = $a->low & 65535;
		$ah = Boot::shiftRightUnsigned($a->low, 16);
		$bl = $b->low & 65535;
		$bh = Boot::shiftRightUnsigned($b->low, 16);
		$p00 = Int32_Impl_::mul($al, $bl);
		$p10 = Int32_Impl_::mul($ah, $bl);
		$p01 = Int32_Impl_::mul($al, $bh);
		$low = $p00;
		$high = (((((Int32_Impl_::mul($ah, $bh) + (Boot::shiftRightUnsigned($p01, 16))) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits) + (Boot::shiftRightUnsigned($p10, 16))) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		$p01 = ($p01 << 16 << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		$low = (($p00 + $p01) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		if (Int32_Impl_::ucompare($low, $p01) < 0) {
			++$high;
			$high = ($high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		}
		$p10 = ($p10 << 16 << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		$low = (($low + $p10) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		if (Int32_Impl_::ucompare($low, $p10) < 0) {
			++$high;
			$high = ($high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		}
		$high = (($high + (((Int32_Impl_::mul($a->low, $b->high) + Int32_Impl_::mul($a->high, $b->low)) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits)) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		return new ___Int64($high, $low);
	}

	/**
	 * @param ___Int64 $a
	 * @param int $b
	 * 
	 * @return ___Int64
	 */
	public static function mulInt ($a, $b) {
		$b_low = $b;
		$al = $a->low & 65535;
		$ah = Boot::shiftRightUnsigned($a->low, 16);
		$bl = $b_low & 65535;
		$bh = Boot::shiftRightUnsigned($b_low, 16);
		$p00 = Int32_Impl_::mul($al, $bl);
		$p10 = Int32_Impl_::mul($ah, $bl);
		$p01 = Int32_Impl_::mul($al, $bh);
		$low = $p00;
		$high = (((((Int32_Impl_::mul($ah, $bh) + (Boot::shiftRightUnsigned($p01, 16))) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits) + (Boot::shiftRightUnsigned($p10, 16))) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		$p01 = ($p01 << 16 << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		$low = (($p00 + $p01) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		if (Int32_Impl_::ucompare($low, $p01) < 0) {
			++$high;
			$high = ($high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		}
		$p10 = ($p10 << 16 << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		$low = (($low + $p10) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		if (Int32_Impl_::ucompare($low, $p10) < 0) {
			++$high;
			$high = ($high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		}
		$high = (($high + (((Int32_Impl_::mul($a->low, $b >> 31) + Int32_Impl_::mul($a->high, $b_low)) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits)) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		return new ___Int64($high, $low);
	}

	/**
	 * Returns the negative of `x`.
	 * 
	 * @param ___Int64 $x
	 * 
	 * @return ___Int64
	 */
	public static function neg ($x) {
		$high = (~$x->high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		$low = ((~$x->low + 1) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		if ($low === 0) {
			++$high;
			$high = ($high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		}
		return new ___Int64($high, $low);
	}

	/**
	 * Returns `true` if `a` is not equal to `b`.
	 * 
	 * @param ___Int64 $a
	 * @param ___Int64 $b
	 * 
	 * @return bool
	 */
	public static function neq ($a, $b) {
		if ($a->high === $b->high) {
			return $a->low !== $b->low;
		} else {
			return true;
		}
	}

	/**
	 * @param ___Int64 $a
	 * @param int $b
	 * 
	 * @return bool
	 */
	public static function neqInt ($a, $b) {
		if ($a->high === ($b >> 31)) {
			return $a->low !== $b;
		} else {
			return true;
		}
	}

	/**
	 * Returns an Int64 with the value of the Int `x`.
	 * `x` is sign-extended to fill 64 bits.
	 * 
	 * @param int $x
	 * 
	 * @return ___Int64
	 */
	public static function ofInt ($x) {
		return new ___Int64($x >> 31, $x);
	}

	/**
	 * Returns the bitwise OR of `a` and `b`.
	 * 
	 * @param ___Int64 $a
	 * @param ___Int64 $b
	 * 
	 * @return ___Int64
	 */
	public static function or ($a, $b) {
		return new ___Int64((($a->high | $b->high) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits, (($a->low | $b->low) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits);
	}

	/**
	 * @param string $sParam
	 * 
	 * @return ___Int64
	 */
	public static function parseString ($sParam) {
		return Int64Helper::parseString($sParam);
	}

	/**
	 * @param ___Int64 $this
	 * 
	 * @return ___Int64
	 */
	public static function postDecrement ($this1) {
		$ret = $this1;
		$x = new ___Int64($this1->high, $this1->low);
		$this1 = $x;
		if ($x->low === 0) {
			$x->high--;
			$x->high = ($x->high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		}
		$x->low--;
		$x->low = ($x->low << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		return $ret;
	}

	/**
	 * @param ___Int64 $this
	 * 
	 * @return ___Int64
	 */
	public static function postIncrement ($this1) {
		$ret = $this1;
		$x = new ___Int64($this1->high, $this1->low);
		$this1 = $x;
		$x->low++;
		$x->low = ($x->low << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		if ($x->low === 0) {
			$x->high++;
			$x->high = ($x->high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		}
		return $ret;
	}

	/**
	 * @param ___Int64 $this
	 * 
	 * @return ___Int64
	 */
	public static function preDecrement ($this1) {
		$x = new ___Int64($this1->high, $this1->low);
		$this1 = $x;
		if ($x->low === 0) {
			$x->high--;
			$x->high = ($x->high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		}
		$x->low--;
		$x->low = ($x->low << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		return $x;
	}

	/**
	 * @param ___Int64 $this
	 * 
	 * @return ___Int64
	 */
	public static function preIncrement ($this1) {
		$x = new ___Int64($this1->high, $this1->low);
		$this1 = $x;
		$x->low++;
		$x->low = ($x->low << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		if ($x->low === 0) {
			$x->high++;
			$x->high = ($x->high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		}
		return $x;
	}

	/**
	 * @param ___Int64 $this
	 * @param int $x
	 * 
	 * @return int
	 */
	public static function set_high ($this1, $x) {
		return $this1->high = $x;
	}

	/**
	 * @param ___Int64 $this
	 * @param int $x
	 * 
	 * @return int
	 */
	public static function set_low ($this1, $x) {
		return $this1->low = $x;
	}

	/**
	 * Returns `a` left-shifted by `b` bits.
	 * 
	 * @param ___Int64 $a
	 * @param int $b
	 * 
	 * @return ___Int64
	 */
	public static function shl ($a, $b) {
		$b &= 63;
		if ($b === 0) {
			return new ___Int64($a->high, $a->low);
		} else if ($b < 32) {
			return new ___Int64((((($a->high << $b << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits) | Boot::shiftRightUnsigned($a->low, (32 - $b))) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits, ($a->low << $b << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits);
		} else {
			return new ___Int64(($a->low << ($b - 32) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits, 0);
		}
	}

	/**
	 * Returns `a` right-shifted by `b` bits in signed mode.
	 * `a` is sign-extended.
	 * 
	 * @param ___Int64 $a
	 * @param int $b
	 * 
	 * @return ___Int64
	 */
	public static function shr ($a, $b) {
		$b &= 63;
		if ($b === 0) {
			return new ___Int64($a->high, $a->low);
		} else if ($b < 32) {
			return new ___Int64((($a->high >> $b) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits, (((($a->high << (32 - $b) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits) | Boot::shiftRightUnsigned($a->low, $b)) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits);
		} else {
			return new ___Int64((($a->high >> 31) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits, (($a->high >> ($b - 32)) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits);
		}
	}

	/**
	 * Returns `a` minus `b`.
	 * 
	 * @param ___Int64 $a
	 * @param ___Int64 $b
	 * 
	 * @return ___Int64
	 */
	public static function sub ($a, $b) {
		$high = (($a->high - $b->high) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		if (Int32_Impl_::ucompare($a->low, $b->low) < 0) {
			--$high;
			$high = ($high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		}
		return new ___Int64($high, (($a->low - $b->low) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits);
	}

	/**
	 * @param ___Int64 $a
	 * @param int $b
	 * 
	 * @return ___Int64
	 */
	public static function subInt ($a, $b) {
		$b_low = $b;
		$high = (($a->high - ($b >> 31)) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		if (Int32_Impl_::ucompare($a->low, $b_low) < 0) {
			--$high;
			$high = ($high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		}
		return new ___Int64($high, (($a->low - $b_low) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits);
	}

	/**
	 * Returns an Int with the value of the Int64 `x`.
	 * Throws an exception  if `x` cannot be represented in 32 bits.
	 * 
	 * @param ___Int64 $x
	 * 
	 * @return int
	 */
	public static function toInt ($x) {
		if ($x->high !== ((($x->low >> 31) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits)) {
			throw Exception::thrown("Overflow");
		}
		return $x->low;
	}

	/**
	 * Returns a signed decimal `String` representation of `x`.
	 * 
	 * @param ___Int64 $x
	 * 
	 * @return string
	 */
	public static function toStr ($x) {
		return Int64_Impl_::toString($x);
	}

	/**
	 * @param ___Int64 $this
	 * 
	 * @return string
	 */
	public static function toString ($this1) {
		$i = $this1;
		if (($i->high === 0) && ($i->low === 0)) {
			return "0";
		}
		$str = "";
		$neg = false;
		if ($i->high < 0) {
			$neg = true;
		}
		$ten = new ___Int64(0, 10);
		while (($i->high !== 0) || ($i->low !== 0)) {
			$r = Int64_Impl_::divMod($i, $ten);
			if ($r->modulus->high < 0) {
				$str = ((((~$r->modulus->low + 1) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits)??'null') . ($str??'null');
				$x = $r->quotient;
				$high = (~$x->high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
				$low = ((~$x->low + 1) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
				if ($low === 0) {
					++$high;
					$high = ($high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
				}
				$i = new ___Int64($high, $low);
			} else {
				$str = ($r->modulus->low??'null') . ($str??'null');
				$i = $r->quotient;
			}
		}
		if ($neg) {
			$str = "-" . ($str??'null');
		}
		return $str;
	}

	/**
	 * Compares `a` and `b` in unsigned mode.
	 * Returns a negative value if `a < b`, positive if `a > b`,
	 * or 0 if `a == b`.
	 * 
	 * @param ___Int64 $a
	 * @param ___Int64 $b
	 * 
	 * @return int
	 */
	public static function ucompare ($a, $b) {
		$v = Int32_Impl_::ucompare($a->high, $b->high);
		if ($v !== 0) {
			return $v;
		} else {
			return Int32_Impl_::ucompare($a->low, $b->low);
		}
	}

	/**
	 * Returns `a` right-shifted by `b` bits in unsigned mode.
	 * `a` is padded with zeroes.
	 * 
	 * @param ___Int64 $a
	 * @param int $b
	 * 
	 * @return ___Int64
	 */
	public static function ushr ($a, $b) {
		$b &= 63;
		if ($b === 0) {
			return new ___Int64($a->high, $a->low);
		} else if ($b < 32) {
			return new ___Int64(Boot::shiftRightUnsigned($a->high, $b), (((($a->high << (32 - $b) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits) | Boot::shiftRightUnsigned($a->low, $b)) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits);
		} else {
			return new ___Int64(0, Boot::shiftRightUnsigned($a->high, ($b - 32)));
		}
	}

	/**
	 * Returns the bitwise XOR of `a` and `b`.
	 * 
	 * @param ___Int64 $a
	 * @param ___Int64 $b
	 * 
	 * @return ___Int64
	 */
	public static function xor ($a, $b) {
		return new ___Int64((($a->high ^ $b->high) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits, (($a->low ^ $b->low) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits);
	}
}

Boot::registerClass(Int64_Impl_::class, 'haxe._Int64.Int64_Impl_');
Boot::registerGetters('haxe\\_Int64\\Int64_Impl_', [
	'low' => true,
	'high' => true
]);
