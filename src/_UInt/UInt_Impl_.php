<?php
/**
 * Generated by Haxe 4.1.1
 */

namespace _UInt;

use \php\Boot;

final class UInt_Impl_ {
	/**
	 * @param int $a
	 * @param int $b
	 * 
	 * @return int
	 */
	public static function add ($a, $b) {
		return $a + $b;
	}

	/**
	 * @param int $a
	 * @param float $b
	 * 
	 * @return float
	 */
	public static function addWithFloat ($a, $b) {
		$int = $a;
		return (($int < 0 ? 4294967296.0 + $int : $int + 0.0)) + $b;
	}

	/**
	 * @param int $a
	 * @param int $b
	 * 
	 * @return int
	 */
	public static function and ($a, $b) {
		return $a & $b;
	}

	/**
	 * @param int $a
	 * @param int $b
	 * 
	 * @return float
	 */
	public static function div ($a, $b) {
		$int = $a;
		$int1 = $b;
		return (($int < 0 ? 4294967296.0 + $int : $int + 0.0)) / (($int1 < 0 ? 4294967296.0 + $int1 : $int1 + 0.0));
	}

	/**
	 * @param int $a
	 * @param float $b
	 * 
	 * @return float
	 */
	public static function divFloat ($a, $b) {
		$int = $a;
		return (($int < 0 ? 4294967296.0 + $int : $int + 0.0)) / $b;
	}

	/**
	 * @param int $a
	 * @param mixed $b
	 * 
	 * @return bool
	 */
	public static function equalsFloat ($a, $b) {
		$int = $a;
		return Boot::equal((($int < 0 ? 4294967296.0 + $int : $int + 0.0)), $b);
	}

	/**
	 * @param int $a
	 * @param mixed $b
	 * 
	 * @return bool
	 */
	public static function equalsInt ($a, $b) {
		return Boot::equal($a, $b);
	}

	/**
	 * @param float $a
	 * @param int $b
	 * 
	 * @return float
	 */
	public static function floatDiv ($a, $b) {
		$int = $b;
		return $a / (($int < 0 ? 4294967296.0 + $int : $int + 0.0));
	}

	/**
	 * @param float $a
	 * @param int $b
	 * 
	 * @return bool
	 */
	public static function floatGt ($a, $b) {
		$int = $b;
		return $a > (($int < 0 ? 4294967296.0 + $int : $int + 0.0));
	}

	/**
	 * @param float $a
	 * @param int $b
	 * 
	 * @return bool
	 */
	public static function floatGte ($a, $b) {
		$int = $b;
		return $a >= (($int < 0 ? 4294967296.0 + $int : $int + 0.0));
	}

	/**
	 * @param float $a
	 * @param int $b
	 * 
	 * @return bool
	 */
	public static function floatLt ($a, $b) {
		$int = $b;
		return $a < (($int < 0 ? 4294967296.0 + $int : $int + 0.0));
	}

	/**
	 * @param float $a
	 * @param int $b
	 * 
	 * @return bool
	 */
	public static function floatLte ($a, $b) {
		$int = $b;
		return $a <= (($int < 0 ? 4294967296.0 + $int : $int + 0.0));
	}

	/**
	 * @param float $a
	 * @param int $b
	 * 
	 * @return float
	 */
	public static function floatMod ($a, $b) {
		$int = $b;
		return fmod($a, (($int < 0 ? 4294967296.0 + $int : $int + 0.0)));
	}

	/**
	 * @param float $a
	 * @param int $b
	 * 
	 * @return float
	 */
	public static function floatSub ($a, $b) {
		$int = $b;
		return $a - (($int < 0 ? 4294967296.0 + $int : $int + 0.0));
	}

	/**
	 * @param int $a
	 * @param int $b
	 * 
	 * @return bool
	 */
	public static function gt ($a, $b) {
		$aNeg = $a < 0;
		if ($aNeg !== ($b < 0)) {
			return $aNeg;
		} else {
			return $a > $b;
		}
	}

	/**
	 * @param int $a
	 * @param float $b
	 * 
	 * @return bool
	 */
	public static function gtFloat ($a, $b) {
		$int = $a;
		return (($int < 0 ? 4294967296.0 + $int : $int + 0.0)) > $b;
	}

	/**
	 * @param int $a
	 * @param int $b
	 * 
	 * @return bool
	 */
	public static function gte ($a, $b) {
		$aNeg = $a < 0;
		if ($aNeg !== ($b < 0)) {
			return $aNeg;
		} else {
			return $a >= $b;
		}
	}

	/**
	 * @param int $a
	 * @param float $b
	 * 
	 * @return bool
	 */
	public static function gteFloat ($a, $b) {
		$int = $a;
		return (($int < 0 ? 4294967296.0 + $int : $int + 0.0)) >= $b;
	}

	/**
	 * @param int $a
	 * @param int $b
	 * 
	 * @return bool
	 */
	public static function lt ($a, $b) {
		$aNeg = $b < 0;
		if ($aNeg !== ($a < 0)) {
			return $aNeg;
		} else {
			return $b > $a;
		}
	}

	/**
	 * @param int $a
	 * @param float $b
	 * 
	 * @return bool
	 */
	public static function ltFloat ($a, $b) {
		$int = $a;
		return (($int < 0 ? 4294967296.0 + $int : $int + 0.0)) < $b;
	}

	/**
	 * @param int $a
	 * @param int $b
	 * 
	 * @return bool
	 */
	public static function lte ($a, $b) {
		$aNeg = $b < 0;
		if ($aNeg !== ($a < 0)) {
			return $aNeg;
		} else {
			return $b >= $a;
		}
	}

	/**
	 * @param int $a
	 * @param float $b
	 * 
	 * @return bool
	 */
	public static function lteFloat ($a, $b) {
		$int = $a;
		return (($int < 0 ? 4294967296.0 + $int : $int + 0.0)) <= $b;
	}

	/**
	 * @param int $a
	 * @param int $b
	 * 
	 * @return int
	 */
	public static function mod ($a, $b) {
		$int = $a;
		$int1 = $b;
		return (int)((fmod((($int < 0 ? 4294967296.0 + $int : $int + 0.0)), (($int1 < 0 ? 4294967296.0 + $int1 : $int1 + 0.0)))));
	}

	/**
	 * @param int $a
	 * @param float $b
	 * 
	 * @return float
	 */
	public static function modFloat ($a, $b) {
		$int = $a;
		return fmod((($int < 0 ? 4294967296.0 + $int : $int + 0.0)), $b);
	}

	/**
	 * @param int $a
	 * @param int $b
	 * 
	 * @return int
	 */
	public static function mul ($a, $b) {
		return $a * $b;
	}

	/**
	 * @param int $a
	 * @param float $b
	 * 
	 * @return float
	 */
	public static function mulWithFloat ($a, $b) {
		$int = $a;
		return (($int < 0 ? 4294967296.0 + $int : $int + 0.0)) * $b;
	}

	/**
	 * @param int $this
	 * 
	 * @return int
	 */
	public static function negBits ($this1) {
		return ~$this1;
	}

	/**
	 * @param int $a
	 * @param mixed $b
	 * 
	 * @return bool
	 */
	public static function notEqualsFloat ($a, $b) {
		$int = $a;
		return !Boot::equal((($int < 0 ? 4294967296.0 + $int : $int + 0.0)), $b);
	}

	/**
	 * @param int $a
	 * @param mixed $b
	 * 
	 * @return bool
	 */
	public static function notEqualsInt ($a, $b) {
		return !Boot::equal($a, $b);
	}

	/**
	 * @param int $a
	 * @param int $b
	 * 
	 * @return int
	 */
	public static function or ($a, $b) {
		return $a | $b;
	}

	/**
	 * @param int $this
	 * 
	 * @return int
	 */
	public static function postfixDecrement ($this1) {
		return $this1--;
	}

	/**
	 * @param int $this
	 * 
	 * @return int
	 */
	public static function postfixIncrement ($this1) {
		return $this1++;
	}

	/**
	 * @param int $this
	 * 
	 * @return int
	 */
	public static function prefixDecrement ($this1) {
		return --$this1;
	}

	/**
	 * @param int $this
	 * 
	 * @return int
	 */
	public static function prefixIncrement ($this1) {
		return ++$this1;
	}

	/**
	 * @param int $a
	 * @param int $b
	 * 
	 * @return int
	 */
	public static function shl ($a, $b) {
		return $a << $b;
	}

	/**
	 * @param int $a
	 * @param int $b
	 * 
	 * @return int
	 */
	public static function shr ($a, $b) {
		return Boot::shiftRightUnsigned($a, $b);
	}

	/**
	 * @param int $a
	 * @param int $b
	 * 
	 * @return int
	 */
	public static function sub ($a, $b) {
		return $a - $b;
	}

	/**
	 * @param int $a
	 * @param float $b
	 * 
	 * @return float
	 */
	public static function subFloat ($a, $b) {
		$int = $a;
		return (($int < 0 ? 4294967296.0 + $int : $int + 0.0)) - $b;
	}

	/**
	 * @param int $this
	 * 
	 * @return float
	 */
	public static function toFloat ($this1) {
		if ($this1 < 0) {
			return 4294967296.0 + $this1;
		} else {
			return $this1 + 0.0;
		}
	}

	/**
	 * @param int $this
	 * 
	 * @return int
	 */
	public static function toInt ($this1) {
		return $this1;
	}

	/**
	 * @param int $this
	 * @param int $radix
	 * 
	 * @return string
	 */
	public static function toString ($this1, $radix = null) {
		return \Std::string(($this1 < 0 ? 4294967296.0 + $this1 : $this1 + 0.0));
	}

	/**
	 * @param int $a
	 * @param int $b
	 * 
	 * @return int
	 */
	public static function ushr ($a, $b) {
		return Boot::shiftRightUnsigned($a, $b);
	}

	/**
	 * @param int $a
	 * @param int $b
	 * 
	 * @return int
	 */
	public static function xor ($a, $b) {
		return $a ^ $b;
	}
}

Boot::registerClass(UInt_Impl_::class, '_UInt.UInt_Impl_');
