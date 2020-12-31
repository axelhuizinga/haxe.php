<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace haxe\ds;

use \php\Boot;

/**
 * ArraySort provides a stable implementation of merge sort through its `sort`
 * method. It should be used instead of `Array.sort` in cases where the order
 * of equal elements has to be retained on all targets.
 */
class ArraySort {
	/**
	 * @param \Array_hx $a
	 * @param \Closure $cmp
	 * @param int $i
	 * @param int $j
	 * 
	 * @return int
	 */
	public static function compare ($a, $cmp, $i, $j) {
		return $cmp(($a->arr[$i] ?? null), ($a->arr[$j] ?? null));
	}

	/**
	 * @param \Array_hx $a
	 * @param \Closure $cmp
	 * @param int $from
	 * @param int $pivot
	 * @param int $to
	 * @param int $len1
	 * @param int $len2
	 * 
	 * @return void
	 */
	public static function doMerge ($a, $cmp, $from, $pivot, $to, $len1, $len2) {
		while (true) {
			$first_cut = null;
			$second_cut = null;
			$len11 = null;
			$len22 = null;
			if (($len1 === 0) || ($len2 === 0)) {
				return;
			}
			if (($len1 + $len2) === 2) {
				if ($cmp(($a->arr[$pivot] ?? null), ($a->arr[$from] ?? null)) < 0) {
					ArraySort::swap($a, $pivot, $from);
				}
				return;
			}
			if ($len1 > $len2) {
				$len11 = $len1 >> 1;
				$first_cut = $from + $len11;
				$second_cut = ArraySort::lower($a, $cmp, $pivot, $to, $first_cut);
				$len22 = $second_cut - $pivot;
			} else {
				$len22 = $len2 >> 1;
				$second_cut = $pivot + $len22;
				$first_cut = ArraySort::upper($a, $cmp, $from, $pivot, $second_cut);
				$len11 = $first_cut - $from;
			}
			ArraySort::rotate($a, $cmp, $first_cut, $pivot, $second_cut);
			$new_mid = $first_cut + $len22;
			ArraySort::doMerge($a, $cmp, $from, $first_cut, $new_mid, $len11, $len22);
			$from = $new_mid;
			$pivot = $second_cut;
			$len1 -= $len11;
			$len2 -= $len22;
		}
	}

	/**
	 * @param int $m
	 * @param int $n
	 * 
	 * @return int
	 */
	public static function gcd ($m, $n) {
		while ($n !== 0) {
			$t = $m % $n;
			$m = $n;
			$n = $t;
		}
		return $m;
	}

	/**
	 * @param \Array_hx $a
	 * @param \Closure $cmp
	 * @param int $from
	 * @param int $to
	 * @param int $val
	 * 
	 * @return int
	 */
	public static function lower ($a, $cmp, $from, $to, $val) {
		$len = $to - $from;
		$half = null;
		$mid = null;
		while ($len > 0) {
			$half = $len >> 1;
			$mid = $from + $half;
			if ($cmp(($a->arr[$mid] ?? null), ($a->arr[$val] ?? null)) < 0) {
				$from = $mid + 1;
				$len = $len - $half - 1;
			} else {
				$len = $half;
			}
		}
		return $from;
	}

	/**
	 * @param \Array_hx $a
	 * @param \Closure $cmp
	 * @param int $from
	 * @param int $to
	 * 
	 * @return void
	 */
	public static function rec ($a, $cmp, $from, $to) {
		$middle = ($from + $to) >> 1;
		if (($to - $from) < 12) {
			if ($to <= $from) {
				return;
			}
			$_g = $from + 1;
			while ($_g < $to) {
				$j = $_g++;
				while ($j > $from) {
					if ($cmp(($a->arr[$j] ?? null), ($a->arr[$j - 1] ?? null)) < 0) {
						ArraySort::swap($a, $j - 1, $j);
					} else {
						break;
					}
					--$j;
				}
			}
			return;
		}
		ArraySort::rec($a, $cmp, $from, $middle);
		ArraySort::rec($a, $cmp, $middle, $to);
		ArraySort::doMerge($a, $cmp, $from, $middle, $to, $middle - $from, $to - $middle);
	}

	/**
	 * @param \Array_hx $a
	 * @param \Closure $cmp
	 * @param int $from
	 * @param int $mid
	 * @param int $to
	 * 
	 * @return void
	 */
	public static function rotate ($a, $cmp, $from, $mid, $to) {
		if (($from === $mid) || ($mid === $to)) {
			return;
		}
		$n = ArraySort::gcd($to - $from, $mid - $from);
		while ($n-- !== 0) {
			$val = ($a->arr[$from + $n] ?? null);
			$shift = $mid - $from;
			$p1 = $from + $n;
			$p2 = $from + $n + $shift;
			while ($p2 !== ($from + $n)) {
				$a->offsetSet($p1, ($a->arr[$p2] ?? null));
				$p1 = $p2;
				if (($to - $p2) > $shift) {
					$p2 += $shift;
				} else {
					$p2 = $from + ($shift - ($to - $p2));
				}
			}
			$a->offsetSet($p1, $val);
		}
	}

	/**
	 * Sorts Array `a` according to the comparison function `cmp`, where
	 * `cmp(x,y)` returns 0 if `x == y`, a positive Int if `x > y` and a
	 * negative Int if `x < y`.
	 * This operation modifies Array `a` in place.
	 * This operation is stable: The order of equal elements is preserved.
	 * If `a` or `cmp` are null, the result is unspecified.
	 * 
	 * @param \Array_hx $a
	 * @param \Closure $cmp
	 * 
	 * @return void
	 */
	public static function sort ($a, $cmp) {
		ArraySort::rec($a, $cmp, 0, $a->length);
	}

	/**
	 * @param \Array_hx $a
	 * @param int $i
	 * @param int $j
	 * 
	 * @return void
	 */
	public static function swap ($a, $i, $j) {
		$tmp = ($a->arr[$i] ?? null);
		$a->offsetSet($i, ($a->arr[$j] ?? null));
		$a->offsetSet($j, $tmp);
	}

	/**
	 * @param \Array_hx $a
	 * @param \Closure $cmp
	 * @param int $from
	 * @param int $to
	 * @param int $val
	 * 
	 * @return int
	 */
	public static function upper ($a, $cmp, $from, $to, $val) {
		$len = $to - $from;
		$half = null;
		$mid = null;
		while ($len > 0) {
			$half = $len >> 1;
			$mid = $from + $half;
			if ($cmp(($a->arr[$val] ?? null), ($a->arr[$mid] ?? null)) < 0) {
				$len = $half;
			} else {
				$from = $mid + 1;
				$len = $len - $half - 1;
			}
		}
		return $from;
	}
}

Boot::registerClass(ArraySort::class, 'haxe.ds.ArraySort');
