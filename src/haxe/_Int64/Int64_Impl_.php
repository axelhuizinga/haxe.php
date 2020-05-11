<?php
/**
 * Generated by Haxe 4.0.5
 */

namespace haxe\_Int64;

use \php\_Boot\HxAnon;
use \php\Boot;
use \haxe\Int64Helper;
use \php\_Boot\HxException;
use \haxe\_Int32\Int32_Impl_;

final class Int64_Impl_ {

	/**
	 * @param ___Int64 $x
	 * 
	 * @return ___Int64
	 */
	public static function _new ($x) {
		$this1 = $x;
		return $this1;
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
			$ret = $high++;
			$high = ($high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		}
		$this1 = new ___Int64($high, $low);
		return $this1;
	}

	/**
	 * @param ___Int64 $a
	 * @param int $b
	 * 
	 * @return ___Int64
	 */
	public static function addInt ($a, $b) {
		$b_high = $b >> 31;
		$b_low = $b;
		$high = (($a->high + $b_high) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		$low = (($a->low + $b_low) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		if (Int32_Impl_::ucompare($low, $a->low) < 0) {
			$ret = $high++;
			$high = ($high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		}
		$this1 = new ___Int64($high, $low);
		return $this1;
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
		$this1 = new ___Int64($a->high & $b->high, $a->low & $b->low);
		return $this1;
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
		$v = ($v !== 0 ? $v : Int32_Impl_::ucompare($a->low, $b->low));
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
		$this1 = new ___Int64((~$a->high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits, (~$a->low << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits);
		return $this1;
	}

	/**
	 * Makes a copy of `this` Int64.
	 * 
	 * @param ___Int64 $this
	 * 
	 * @return ___Int64
	 */
	public static function copy ($this1) {
		$this2 = new ___Int64($this1->high, $this1->low);
		return $this2;
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
		$this1 = new ___Int64($b >> 31, $b);
		return Int64_Impl_::divMod($a, $this1)->quotient;
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
				throw new HxException("divide by zero");
			} else if ($__hx__switch === 1) {
				$this1 = new ___Int64($dividend->high, $dividend->low);
				$this2 = new ___Int64(0, 0);
				return new HxAnon([
					"quotient" => $this1,
					"modulus" => $this2,
				]);
			}
		}
		$divSign = ($dividend->high < 0) !== ($divisor->high < 0);
		$modulus = null;
		if ($dividend->high < 0) {
			$high = (~$dividend->high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
			$low = ((~$dividend->low + 1) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
			if ($low === 0) {
				$ret = $high++;
				$high = ($high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
			}
			$this3 = new ___Int64($high, $low);
			$modulus = $this3;
		} else {
			$this4 = new ___Int64($dividend->high, $dividend->low);
			$modulus = $this4;
		}
		if ($divisor->high < 0) {
			$high1 = (~$divisor->high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
			$low1 = ((~$divisor->low + 1) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
			if ($low1 === 0) {
				$ret1 = $high1++;
				$high1 = ($high1 << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
			}
			$this5 = new ___Int64($high1, $low1);
			$divisor = $this5;
		} else {
			$divisor = $divisor;
		}
		$this6 = new ___Int64(0, 0);
		$quotient = $this6;
		$this7 = new ___Int64(0, 1);
		$mask = $this7;
		while (!($divisor->high < 0)) {
			$v = Int32_Impl_::ucompare($divisor->high, $modulus->high);
			$cmp = ($v !== 0 ? $v : Int32_Impl_::ucompare($divisor->low, $modulus->low));
			$b = 1;
			$b &= 63;
			if ($b === 0) {
				$this8 = new ___Int64($divisor->high, $divisor->low);
				$divisor = $this8;
			} else if ($b < 32) {
				$this9 = new ___Int64((((($divisor->high << $b << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits) | Boot::shiftRightUnsigned($divisor->low, (32 - $b))) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits, ($divisor->low << $b << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits);
				$divisor = $this9;
			} else {
				$this10 = new ___Int64(($divisor->low << ($b - 32) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits, 0);
				$divisor = $this10;
			}
			$b1 = 1;
			$b1 &= 63;
			if ($b1 === 0) {
				$this11 = new ___Int64($mask->high, $mask->low);
				$mask = $this11;
			} else if ($b1 < 32) {
				$this12 = new ___Int64((((($mask->high << $b1 << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits) | Boot::shiftRightUnsigned($mask->low, (32 - $b1))) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits, ($mask->low << $b1 << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits);
				$mask = $this12;
			} else {
				$this13 = new ___Int64(($mask->low << ($b1 - 32) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits, 0);
				$mask = $this13;
			}
			if ($cmp >= 0) {
				break;
			}
		}
		while (true) {
			$b_high = 0;
			$b_low = 0;
			if (!(($mask->high !== $b_high) || ($mask->low !== $b_low))) {
				break;
			}
			$v1 = Int32_Impl_::ucompare($modulus->high, $divisor->high);
			if ((($v1 !== 0 ? $v1 : Int32_Impl_::ucompare($modulus->low, $divisor->low))) >= 0) {
				$this14 = new ___Int64((($quotient->high | $mask->high) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits, (($quotient->low | $mask->low) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits);
				$quotient = $this14;
				$high2 = (($modulus->high - $divisor->high) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
				$low2 = (($modulus->low - $divisor->low) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
				if (Int32_Impl_::ucompare($modulus->low, $divisor->low) < 0) {
					$ret2 = $high2--;
					$high2 = ($high2 << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
				}
				$this15 = new ___Int64($high2, $low2);
				$modulus = $this15;
			}
			$b2 = 1;
			$b2 &= 63;
			if ($b2 === 0) {
				$this16 = new ___Int64($mask->high, $mask->low);
				$mask = $this16;
			} else if ($b2 < 32) {
				$this17 = new ___Int64(Boot::shiftRightUnsigned($mask->high, $b2), (((($mask->high << (32 - $b2) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits) | Boot::shiftRightUnsigned($mask->low, $b2)) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits);
				$mask = $this17;
			} else {
				$this18 = new ___Int64(0, Boot::shiftRightUnsigned($mask->high, ($b2 - 32)));
				$mask = $this18;
			}
			$b3 = 1;
			$b3 &= 63;
			if ($b3 === 0) {
				$this19 = new ___Int64($divisor->high, $divisor->low);
				$divisor = $this19;
			} else if ($b3 < 32) {
				$this20 = new ___Int64(Boot::shiftRightUnsigned($divisor->high, $b3), (((($divisor->high << (32 - $b3) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits) | Boot::shiftRightUnsigned($divisor->low, $b3)) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits);
				$divisor = $this20;
			} else {
				$this21 = new ___Int64(0, Boot::shiftRightUnsigned($divisor->high, ($b3 - 32)));
				$divisor = $this21;
			}
		}
		if ($divSign) {
			$high3 = (~$quotient->high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
			$low3 = ((~$quotient->low + 1) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
			if ($low3 === 0) {
				$ret3 = $high3++;
				$high3 = ($high3 << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
			}
			$this22 = new ___Int64($high3, $low3);
			$quotient = $this22;
		}
		if ($dividend->high < 0) {
			$high4 = (~$modulus->high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
			$low4 = ((~$modulus->low + 1) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
			if ($low4 === 0) {
				$ret4 = $high4++;
				$high4 = ($high4 << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
			}
			$this23 = new ___Int64($high4, $low4);
			$modulus = $this23;
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
		$b_high = $b >> 31;
		$b_low = $b;
		if ($a->high === $b_high) {
			return $a->low === $b_low;
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
		$v = ($v !== 0 ? $v : Int32_Impl_::ucompare($a->low, $b->low));
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
		$b_low = $b;
		$v = (($a->high - $b_high) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		$v = ($v !== 0 ? $v : Int32_Impl_::ucompare($a->low, $b_low));
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
		$v = ($v !== 0 ? $v : Int32_Impl_::ucompare($a->low, $b->low));
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
		$b_low = $b;
		$v = (($a->high - $b_high) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		$v = ($v !== 0 ? $v : Int32_Impl_::ucompare($a->low, $b_low));
		return (($a->high < 0 ? ($b_high < 0 ? $v : -1) : ($b_high >= 0 ? $v : 1))) >= 0;
	}

	/**
	 * @param int $a
	 * @param ___Int64 $b
	 * 
	 * @return ___Int64
	 */
	public static function intDiv ($a, $b) {
		$this1 = new ___Int64($a >> 31, $a);
		$x = Int64_Impl_::divMod($this1, $b)->quotient;
		if ($x->high !== ((($x->low >> 31) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits)) {
			throw new HxException("Overflow");
		}
		$x1 = $x->low;
		$this2 = new ___Int64($x1 >> 31, $x1);
		return $this2;
	}

	/**
	 * @param int $a
	 * @param ___Int64 $b
	 * 
	 * @return bool
	 */
	public static function intGt ($a, $b) {
		$a_high = $a >> 31;
		$a_low = $a;
		$v = (($a_high - $b->high) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		$v = ($v !== 0 ? $v : Int32_Impl_::ucompare($a_low, $b->low));
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
		$a_low = $a;
		$v = (($a_high - $b->high) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		$v = ($v !== 0 ? $v : Int32_Impl_::ucompare($a_low, $b->low));
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
		$a_low = $a;
		$v = (($a_high - $b->high) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		$v = ($v !== 0 ? $v : Int32_Impl_::ucompare($a_low, $b->low));
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
		$a_low = $a;
		$v = (($a_high - $b->high) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		$v = ($v !== 0 ? $v : Int32_Impl_::ucompare($a_low, $b->low));
		return (($a_high < 0 ? ($b->high < 0 ? $v : -1) : ($b->high >= 0 ? $v : 1))) <= 0;
	}

	/**
	 * @param int $a
	 * @param ___Int64 $b
	 * 
	 * @return ___Int64
	 */
	public static function intMod ($a, $b) {
		$this1 = new ___Int64($a >> 31, $a);
		$x = Int64_Impl_::divMod($this1, $b)->modulus;
		if ($x->high !== ((($x->low >> 31) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits)) {
			throw new HxException("Overflow");
		}
		$x1 = $x->low;
		$this2 = new ___Int64($x1 >> 31, $x1);
		return $this2;
	}

	/**
	 * @param int $a
	 * @param ___Int64 $b
	 * 
	 * @return ___Int64
	 */
	public static function intSub ($a, $b) {
		$a_high = $a >> 31;
		$a_low = $a;
		$high = (($a_high - $b->high) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		$low = (($a_low - $b->low) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		if (Int32_Impl_::ucompare($a_low, $b->low) < 0) {
			$ret = $high--;
			$high = ($high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		}
		$this1 = new ___Int64($high, $low);
		return $this1;
	}

	/**
	 * Returns whether the value `val` is of type `haxe.Int64`
	 * 
	 * @param mixed $val
	 * 
	 * @return bool
	 */
	public static function is ($val) {
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
		$b_high = 0;
		$b_low = 0;
		if ($x->high === $b_high) {
			return $x->low === $b_low;
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
		$v = ($v !== 0 ? $v : Int32_Impl_::ucompare($a->low, $b->low));
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
		$b_low = $b;
		$v = (($a->high - $b_high) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		$v = ($v !== 0 ? $v : Int32_Impl_::ucompare($a->low, $b_low));
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
		$v = ($v !== 0 ? $v : Int32_Impl_::ucompare($a->low, $b->low));
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
		$b_low = $b;
		$v = (($a->high - $b_high) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		$v = ($v !== 0 ? $v : Int32_Impl_::ucompare($a->low, $b_low));
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
		$this1 = new ___Int64($high, $low);
		return $this1;
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
		$this1 = new ___Int64($b >> 31, $b);
		$x = Int64_Impl_::divMod($a, $this1)->modulus;
		if ($x->high !== ((($x->low >> 31) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits)) {
			throw new HxException("Overflow");
		}
		$x1 = $x->low;
		$this2 = new ___Int64($x1 >> 31, $x1);
		return $this2;
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
		$mask = 65535;
		$al = $a->low & $mask;
		$ah = Boot::shiftRightUnsigned($a->low, 16);
		$bl = $b->low & $mask;
		$bh = Boot::shiftRightUnsigned($b->low, 16);
		$p00 = Int32_Impl_::mul($al, $bl);
		$p10 = Int32_Impl_::mul($ah, $bl);
		$p01 = Int32_Impl_::mul($al, $bh);
		$p11 = Int32_Impl_::mul($ah, $bh);
		$low = $p00;
		$high = ((((($p11 + (Boot::shiftRightUnsigned($p01, 16))) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits) + (Boot::shiftRightUnsigned($p10, 16))) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		$p01 = ($p01 << 16 << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		$low = (($low + $p01) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		if (Int32_Impl_::ucompare($low, $p01) < 0) {
			$ret = $high++;
			$high = ($high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		}
		$p10 = ($p10 << 16 << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		$low = (($low + $p10) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		if (Int32_Impl_::ucompare($low, $p10) < 0) {
			$ret1 = $high++;
			$high = ($high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		}
		$high = (($high + (((Int32_Impl_::mul($a->low, $b->high) + Int32_Impl_::mul($a->high, $b->low)) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits)) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		$this1 = new ___Int64($high, $low);
		return $this1;
	}

	/**
	 * @param ___Int64 $a
	 * @param int $b
	 * 
	 * @return ___Int64
	 */
	public static function mulInt ($a, $b) {
		$b_high = $b >> 31;
		$b_low = $b;
		$mask = 65535;
		$al = $a->low & $mask;
		$ah = Boot::shiftRightUnsigned($a->low, 16);
		$bl = $b_low & $mask;
		$bh = Boot::shiftRightUnsigned($b_low, 16);
		$p00 = Int32_Impl_::mul($al, $bl);
		$p10 = Int32_Impl_::mul($ah, $bl);
		$p01 = Int32_Impl_::mul($al, $bh);
		$p11 = Int32_Impl_::mul($ah, $bh);
		$low = $p00;
		$high = ((((($p11 + (Boot::shiftRightUnsigned($p01, 16))) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits) + (Boot::shiftRightUnsigned($p10, 16))) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		$p01 = ($p01 << 16 << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		$low = (($low + $p01) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		if (Int32_Impl_::ucompare($low, $p01) < 0) {
			$ret = $high++;
			$high = ($high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		}
		$p10 = ($p10 << 16 << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		$low = (($low + $p10) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		if (Int32_Impl_::ucompare($low, $p10) < 0) {
			$ret1 = $high++;
			$high = ($high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		}
		$high = (($high + (((Int32_Impl_::mul($a->low, $b_high) + Int32_Impl_::mul($a->high, $b_low)) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits)) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		$this1 = new ___Int64($high, $low);
		return $this1;
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
			$ret = $high++;
			$high = ($high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		}
		$this1 = new ___Int64($high, $low);
		return $this1;
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
		if (!($a->high !== $b->high)) {
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
		$b_high = $b >> 31;
		$b_low = $b;
		if (!($a->high !== $b_high)) {
			return $a->low !== $b_low;
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
		$this1 = new ___Int64($x >> 31, $x);
		return $this1;
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
		$this1 = new ___Int64((($a->high | $b->high) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits, (($a->low | $b->low) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits);
		return $this1;
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
		$this2 = new ___Int64($this1->high, $this1->low);
		$this1 = $this2;
		if ($this1->low === 0) {
			$ret1 = $this1->high--;
			$this1->high = ($this1->high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		}
		$ret2 = $this1->low--;
		$this1->low = ($this1->low << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;


		return $ret;
	}

	/**
	 * @param ___Int64 $this
	 * 
	 * @return ___Int64
	 */
	public static function postIncrement ($this1) {
		$ret = $this1;
		$this2 = new ___Int64($this1->high, $this1->low);
		$this1 = $this2;
		$ret1 = $this1->low++;
		$this1->low = ($this1->low << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;

		if ($this1->low === 0) {
			$ret2 = $this1->high++;
			$this1->high = ($this1->high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		}

		return $ret;
	}

	/**
	 * @param ___Int64 $this
	 * 
	 * @return ___Int64
	 */
	public static function preDecrement ($this1) {
		$this2 = new ___Int64($this1->high, $this1->low);
		$this1 = $this2;
		if ($this1->low === 0) {
			$ret = $this1->high--;
			$this1->high = ($this1->high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		}
		$ret1 = $this1->low--;
		$this1->low = ($this1->low << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;

		return $this1;
	}

	/**
	 * @param ___Int64 $this
	 * 
	 * @return ___Int64
	 */
	public static function preIncrement ($this1) {
		$this2 = new ___Int64($this1->high, $this1->low);
		$this1 = $this2;
		$ret = $this1->low++;
		$this1->low = ($this1->low << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;

		if ($this1->low === 0) {
			$ret1 = $this1->high++;
			$this1->high = ($this1->high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		}
		return $this1;
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
			$this1 = new ___Int64($a->high, $a->low);
			return $this1;
		} else if ($b < 32) {
			$this2 = new ___Int64((((($a->high << $b << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits) | Boot::shiftRightUnsigned($a->low, (32 - $b))) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits, ($a->low << $b << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits);
			return $this2;
		} else {
			$this3 = new ___Int64(($a->low << ($b - 32) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits, 0);
			return $this3;
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
			$this1 = new ___Int64($a->high, $a->low);
			return $this1;
		} else if ($b < 32) {
			$this2 = new ___Int64((($a->high >> $b) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits, (((($a->high << (32 - $b) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits) | Boot::shiftRightUnsigned($a->low, $b)) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits);
			return $this2;
		} else {
			$this3 = new ___Int64((($a->high >> 31) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits, (($a->high >> ($b - 32)) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits);
			return $this3;
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
		$low = (($a->low - $b->low) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		if (Int32_Impl_::ucompare($a->low, $b->low) < 0) {
			$ret = $high--;
			$high = ($high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		}
		$this1 = new ___Int64($high, $low);
		return $this1;
	}

	/**
	 * @param ___Int64 $a
	 * @param int $b
	 * 
	 * @return ___Int64
	 */
	public static function subInt ($a, $b) {
		$b_high = $b >> 31;
		$b_low = $b;
		$high = (($a->high - $b_high) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		$low = (($a->low - $b_low) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		if (Int32_Impl_::ucompare($a->low, $b_low) < 0) {
			$ret = $high--;
			$high = ($high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
		}
		$this1 = new ___Int64($high, $low);
		return $this1;
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
			throw new HxException("Overflow");
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
		$b_high = 0;
		$b_low = 0;
		if (($i->high === $b_high) && ($i->low === $b_low)) {
			return "0";
		}
		$str = "";
		$neg = false;
		if ($i->high < 0) {
			$neg = true;
		}
		$this2 = new ___Int64(0, 10);
		$ten = $this2;
		while (true) {
			$b_high1 = 0;
			$b_low1 = 0;
			if (!(($i->high !== $b_high1) || ($i->low !== $b_low1))) {
				break;
			}
			$r = Int64_Impl_::divMod($i, $ten);
			if ($r->modulus->high < 0) {
				$x = $r->modulus;
				$high = (~$x->high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
				$low = ((~$x->low + 1) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
				if ($low === 0) {
					$ret = $high++;
					$high = ($high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
				}
				$this_high = $high;
				$this_low = $low;
				$str = ($this_low??'null') . ($str??'null');
				$x1 = $r->quotient;
				$high1 = (~$x1->high << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
				$low1 = ((~$x1->low + 1) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
				if ($low1 === 0) {
					$ret1 = $high1++;
					$high1 = ($high1 << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits;
				}
				$this3 = new ___Int64($high1, $low1);
				$i = $this3;
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
			$this1 = new ___Int64($a->high, $a->low);
			return $this1;
		} else if ($b < 32) {
			$this2 = new ___Int64(Boot::shiftRightUnsigned($a->high, $b), (((($a->high << (32 - $b) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits) | Boot::shiftRightUnsigned($a->low, $b)) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits);
			return $this2;
		} else {
			$this3 = new ___Int64(0, Boot::shiftRightUnsigned($a->high, ($b - 32)));
			return $this3;
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
		$this1 = new ___Int64((($a->high ^ $b->high) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits, (($a->low ^ $b->low) << Int32_Impl_::$extraBits) >> Int32_Impl_::$extraBits);
		return $this1;
	}
}

Boot::registerClass(Int64_Impl_::class, 'haxe._Int64.Int64_Impl_');
Boot::registerGetters('haxe\\_Int64\\Int64_Impl_', [
	'low' => true,
	'high' => true
]);