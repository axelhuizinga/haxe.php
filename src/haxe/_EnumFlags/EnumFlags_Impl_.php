<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace haxe\_EnumFlags;

use \php\Boot;

final class EnumFlags_Impl_ {
	/**
	 * Initializes the bitflags to `i`.
	 * 
	 * @param int $i
	 * 
	 * @return int
	 */
	public static function _new ($i = 0) {
		if ($i === null) {
			$i = 0;
		}
		return $i;
	}

	/**
	 * Checks if the index of enum instance `v` is set.
	 * This method is optimized if `v` is an enum instance expression such as
	 * `SomeEnum.SomeCtor`.
	 * If `v` is `null`, the result is unspecified.
	 * 
	 * @param int $this
	 * @param mixed $v
	 * 
	 * @return bool
	 */
	public static function has ($this1, $v) {
		return ($this1 & (1 << $v->index)) !== 0;
	}

	/**
	 * Convert a integer bitflag into a typed one (this is a no-op, it does not
	 * have any impact on speed).
	 * 
	 * @param int $i
	 * 
	 * @return int
	 */
	public static function ofInt ($i) {
		$i1 = $i;
		if ($i === null) {
			$i1 = 0;
		}
		return $i1;
	}

	/**
	 * Sets the index of enum instance `v`.
	 * This method is optimized if `v` is an enum instance expression such as
	 * `SomeEnum.SomeCtor`.
	 * If `v` is `null`, the result is unspecified.
	 * 
	 * @param int $this
	 * @param mixed $v
	 * 
	 * @return void
	 */
	public static function set ($this1, $v) {
		$this1 |= 1 << $v->index;
	}

	/**
	 * Convert the typed bitflag into the corresponding int value (this is a
	 * no-op, it doesn't have any impact on speed).
	 * 
	 * @param int $this
	 * 
	 * @return int
	 */
	public static function toInt ($this1) {
		return $this1;
	}

	/**
	 * Unsets the index of enum instance `v`.
	 * This method is optimized if `v` is an enum instance expression such as
	 * `SomeEnum.SomeCtor`.
	 * If `v` is `null`, the result is unspecified.
	 * 
	 * @param int $this
	 * @param mixed $v
	 * 
	 * @return void
	 */
	public static function unset ($this1, $v) {
		$this1 &= -1 - (1 << $v->index);
	}
}

Boot::registerClass(EnumFlags_Impl_::class, 'haxe._EnumFlags.EnumFlags_Impl_');