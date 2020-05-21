<?php
/**
 * Generated by Haxe 4.1.0
 */

use \haxe\iterators\ArrayIterator as IteratorsArrayIterator;
use \php\Boot;
use \php\_Boot\HxClosure;
use \haxe\iterators\ArrayKeyValueIterator;
use \haxe\NativeStackTrace;

final class Array_hx implements \JsonSerializable, \Countable, \IteratorAggregate, \ArrayAccess {
	/**
	 * @var mixed
	 */
	public $arr;
	/**
	 * @var int
	 * The length of `this` Array.
	 */
	public $length;

	/**
	 * @param mixed $arr
	 * 
	 * @return Array_hx
	 */
	public static function wrap ($arr) {
		$a = new Array_hx();
		$a->arr = $arr;
		$a->length = count($arr);
		return $a;
	}

	/**
	 * Creates a new Array.
	 * 
	 * @return void
	 */
	public function __construct () {
		$this->arr = [];
		$this->length = 0;
	}

	/**
	 * Returns a new Array by appending the elements of `a` to the elements of
	 * `this` Array.
	 * This operation does not modify `this` Array.
	 * If `a` is the empty Array `[]`, a copy of `this` Array is returned.
	 * The length of the returned Array is equal to the sum of `this.length`
	 * and `a.length`.
	 * If `a` is `null`, the result is unspecified.
	 * 
	 * @param Array_hx $a
	 * 
	 * @return Array_hx
	 */
	public function concat ($a) {
		return Array_hx::wrap(array_merge($this->arr, $a->arr));
	}

	/**
	 * Returns whether `this` Array contains `x`.
	 * If `x` is found by checking standard equality, the function returns `true`, otherwise
	 * the function returns `false`.
	 * 
	 * @param mixed $x
	 * 
	 * @return bool
	 */
	public function contains ($x) {
		return $this->indexOf($x) !== -1;
	}

	/**
	 * Returns a shallow copy of `this` Array.
	 * The elements are not copied and retain their identity, so
	 * `a[i] == a.copy()[i]` is true for any valid `i`. However,
	 * `a == a.copy()` is always false.
	 * 
	 * @return Array_hx
	 */
	public function copy () {
		return (clone $this);
	}

	/**
	 * @return int
	 */
	public function count () {
		return $this->length;
	}

	/**
	 * Returns an Array containing those elements of `this` for which `f`
	 * returned true.
	 * The individual elements are not duplicated and retain their identity.
	 * If `f` is null, the result is unspecified.
	 * 
	 * @param \Closure $f
	 * 
	 * @return Array_hx
	 */
	public function filter ($f) {
		$result = [];
		$data = $this->arr;
		$_g_current = 0;
		$_g_length = count($data);
		while ($_g_current < $_g_length) {
			$item = $data[$_g_current++];
			if ($f($item)) {
				$result[] = $item;
			}
		}
		return Array_hx::wrap($result);
	}

	/**
	 * @return \Traversable
	 */
	public function getIterator () {
		return new \ArrayIterator($this->arr);
	}

	/**
	 * Returns position of the first occurrence of `x` in `this` Array, searching front to back.
	 * If `x` is found by checking standard equality, the function returns its index.
	 * If `x` is not found, the function returns -1.
	 * If `fromIndex` is specified, it will be used as the starting index to search from,
	 * otherwise search starts with zero index. If it is negative, it will be taken as the
	 * offset from the end of `this` Array to compute the starting index. If given or computed
	 * starting index is less than 0, the whole array will be searched, if it is greater than
	 * or equal to the length of `this` Array, the function returns -1.
	 * 
	 * @param mixed $x
	 * @param int $fromIndex
	 * 
	 * @return int
	 */
	public function indexOf ($x, $fromIndex = null) {
		$tmp = null;
		if (($fromIndex === null) && !($x instanceof HxClosure)) {
			$value = $x;
			$tmp = !(is_int($value) || is_float($value));
		} else {
			$tmp = false;
		}
		if ($tmp) {
			$index = array_search($x, $this->arr, true);
			if ($index === false) {
				return -1;
			} else {
				return $index;
			}
		}
		if ($fromIndex === null) {
			$fromIndex = 0;
		} else {
			if ($fromIndex < 0) {
				$fromIndex += $this->length;
			}
			if ($fromIndex < 0) {
				$fromIndex = 0;
			}
		}
		while ($fromIndex < $this->length) {
			if (Boot::equal($this->arr[$fromIndex], $x)) {
				return $fromIndex;
			}
			++$fromIndex;
		}
		return -1;
	}

	/**
	 * Inserts the element `x` at the position `pos`.
	 * This operation modifies `this` Array in place.
	 * The offset is calculated like so:
	 * - If `pos` exceeds `this.length`, the offset is `this.length`.
	 * - If `pos` is negative, the offset is calculated from the end of `this`
	 * Array, i.e. `this.length + pos`. If this yields a negative value, the
	 * offset is 0.
	 * - Otherwise, the offset is `pos`.
	 * If the resulting offset does not exceed `this.length`, all elements from
	 * and including that offset to the end of `this` Array are moved one index
	 * ahead.
	 * 
	 * @param int $pos
	 * @param mixed $x
	 * 
	 * @return void
	 */
	public function insert ($pos, $x) {
		$this->length++;
		array_splice($this->arr, $pos, 0, [$x]);
	}

	/**
	 * Returns an iterator of the Array values.
	 * 
	 * @return IteratorsArrayIterator
	 */
	public function iterator () {
		return new IteratorsArrayIterator($this);
	}

	/**
	 * Returns a string representation of `this` Array, with `sep` separating
	 * each element.
	 * The result of this operation is equal to `Std.string(this[0]) + sep +
	 * Std.string(this[1]) + sep + ... + sep + Std.string(this[this.length-1])`
	 * If `this` is the empty Array `[]`, the result is the empty String `""`.
	 * If `this` has exactly one element, the result is equal to a call to
	 * `Std.string(this[0])`.
	 * If `sep` is null, the result is unspecified.
	 * 
	 * @param string $sep
	 * 
	 * @return string
	 */
	public function join ($sep) {
		return implode($sep, array_map((Boot::class??'null') . "::stringify", $this->arr));
	}

	/**
	 * @return mixed
	 */
	public function jsonSerialize () {
		return $this->arr;
	}

	/**
	 * Returns an iterator of the Array indices and values.
	 * 
	 * @return ArrayKeyValueIterator
	 */
	public function keyValueIterator () {
		return new ArrayKeyValueIterator($this);
	}

	/**
	 * Returns position of the last occurrence of `x` in `this` Array, searching back to front.
	 * If `x` is found by checking standard equality, the function returns its index.
	 * If `x` is not found, the function returns -1.
	 * If `fromIndex` is specified, it will be used as the starting index to search from,
	 * otherwise search starts with the last element index. If it is negative, it will be
	 * taken as the offset from the end of `this` Array to compute the starting index. If
	 * given or computed starting index is greater than or equal to the length of `this` Array,
	 * the whole array will be searched, if it is less than 0, the function returns -1.
	 * 
	 * @param mixed $x
	 * @param int $fromIndex
	 * 
	 * @return int
	 */
	public function lastIndexOf ($x, $fromIndex = null) {
		if (($fromIndex === null) || ($fromIndex >= $this->length)) {
			$fromIndex = $this->length - 1;
		}
		if ($fromIndex < 0) {
			$fromIndex += $this->length;
		}
		while ($fromIndex >= 0) {
			if (Boot::equal($this->arr[$fromIndex], $x)) {
				return $fromIndex;
			}
			--$fromIndex;
		}
		return -1;
	}

	/**
	 * Creates a new Array by applying function `f` to all elements of `this`.
	 * The order of elements is preserved.
	 * If `f` is null, the result is unspecified.
	 * 
	 * @param \Closure $f
	 * 
	 * @return Array_hx
	 */
	public function map ($f) {
		$result = [];
		$data = $this->arr;
		$_g_current = 0;
		$_g_length = count($data);
		while ($_g_current < $_g_length) {
			$result[] = $f($data[$_g_current++]);
		}
		return Array_hx::wrap($result);
	}

	/**
	 * @param int $offset
	 * 
	 * @return bool
	 */
	public function offsetExists ($offset) {
		return $offset < $this->length;
	}

	/**
	 * @param int $offset
	 * 
	 * @return mixed
	 */
	public function &offsetGet ($offset) {
		try {
			return $this->arr[$offset];
		} catch(\Throwable $_g) {
			NativeStackTrace::saveStack($_g);
			return null;
		}
	}

	/**
	 * @param int $offset
	 * @param mixed $value
	 * 
	 * @return void
	 */
	public function offsetSet ($offset, $value) {
		if ($this->length <= $offset) {
			$_g = $this->length;
			$_g1 = $offset + 1;
			while ($_g < $_g1) {
				$this->arr[$_g++] = null;
			}
			$this->length = $offset + 1;
		}
		$this->arr[$offset] = $value;
		return $value;
	}

	/**
	 * @param int $offset
	 * 
	 * @return void
	 */
	public function offsetUnset ($offset) {
		if (($offset >= 0) && ($offset < $this->length)) {
			array_splice($this->arr, $offset, 1);
			--$this->length;
		}
	}

	/**
	 * Removes the last element of `this` Array and returns it.
	 * This operation modifies `this` Array in place.
	 * If `this` has at least one element, `this.length` will decrease by 1.
	 * If `this` is the empty Array `[]`, null is returned and the length
	 * remains 0.
	 * 
	 * @return mixed
	 */
	public function pop () {
		if ($this->length > 0) {
			$this->length--;
		}
		return array_pop($this->arr);
	}

	/**
	 * Adds the element `x` at the end of `this` Array and returns the new
	 * length of `this` Array.
	 * This operation modifies `this` Array in place.
	 * `this.length` increases by 1.
	 * 
	 * @param mixed $x
	 * 
	 * @return int
	 */
	public function push ($x) {
		$this->arr[$this->length++] = $x;
		return $this->length;
	}

	/**
	 * Removes the first occurrence of `x` in `this` Array.
	 * This operation modifies `this` Array in place.
	 * If `x` is found by checking standard equality, it is removed from `this`
	 * Array and all following elements are reindexed accordingly. The function
	 * then returns true.
	 * If `x` is not found, `this` Array is not changed and the function
	 * returns false.
	 * 
	 * @param mixed $x
	 * 
	 * @return bool
	 */
	public function remove ($x) {
		$result = false;
		$_g = 0;
		$_g1 = $this->length;
		while ($_g < $_g1) {
			$index = $_g++;
			if (Boot::equal($this->arr[$index], $x)) {
				array_splice($this->arr, $index, 1);
				$this->length--;
				$result = true;
				break;
			}
		}
		return $result;
	}

	/**
	 * Set the length of the Array.
	 * If `len` is shorter than the array's current size, the last
	 * `length - len` elements will be removed. If `len` is longer, the Array
	 * will be extended, with new elements set to a target-specific default
	 * value:
	 * - always null on dynamic targets
	 * - 0, 0.0 or false for Int, Float and Bool respectively on static targets
	 * - null for other types on static targets
	 * 
	 * @param int $len
	 * 
	 * @return void
	 */
	public function resize ($len) {
		if ($this->length < $len) {
			$this->arr = array_pad($this->arr, $len, null);
		} else if ($this->length > $len) {
			array_splice($this->arr, $len, $this->length - $len);
		}
		$this->length = $len;
	}

	/**
	 * Reverse the order of elements of `this` Array.
	 * This operation modifies `this` Array in place.
	 * If `this.length < 2`, `this` remains unchanged.
	 * 
	 * @return void
	 */
	public function reverse () {
		$this->arr = array_reverse($this->arr);
	}

	/**
	 * Removes the first element of `this` Array and returns it.
	 * This operation modifies `this` Array in place.
	 * If `this` has at least one element, `this`.length and the index of each
	 * remaining element is decreased by 1.
	 * If `this` is the empty Array `[]`, `null` is returned and the length
	 * remains 0.
	 * 
	 * @return mixed
	 */
	public function shift () {
		if ($this->length > 0) {
			$this->length--;
		}
		return array_shift($this->arr);
	}

	/**
	 * Creates a shallow copy of the range of `this` Array, starting at and
	 * including `pos`, up to but not including `end`.
	 * This operation does not modify `this` Array.
	 * The elements are not copied and retain their identity.
	 * If `end` is omitted or exceeds `this.length`, it defaults to the end of
	 * `this` Array.
	 * If `pos` or `end` are negative, their offsets are calculated from the
	 * end of `this` Array by `this.length + pos` and `this.length + end`
	 * respectively. If this yields a negative value, 0 is used instead.
	 * If `pos` exceeds `this.length` or if `end` is less than or equals
	 * `pos`, the result is `[]`.
	 * 
	 * @param int $pos
	 * @param int $end
	 * 
	 * @return Array_hx
	 */
	public function slice ($pos, $end = null) {
		if ($pos < 0) {
			$pos += $this->length;
		}
		if ($pos < 0) {
			$pos = 0;
		}
		if ($end === null) {
			return Array_hx::wrap(array_slice($this->arr, $pos));
		} else {
			if ($end < 0) {
				$end += $this->length;
			}
			if ($end <= $pos) {
				return new Array_hx();
			} else {
				return Array_hx::wrap(array_slice($this->arr, $pos, $end - $pos));
			}
		}
	}

	/**
	 * Sorts `this` Array according to the comparison function `f`, where
	 * `f(x,y)` returns 0 if x == y, a positive Int if x > y and a
	 * negative Int if x < y.
	 * This operation modifies `this` Array in place.
	 * The sort operation is not guaranteed to be stable, which means that the
	 * order of equal elements may not be retained. For a stable Array sorting
	 * algorithm, `haxe.ds.ArraySort.sort()` can be used instead.
	 * If `f` is null, the result is unspecified.
	 * 
	 * @param \Closure $f
	 * 
	 * @return void
	 */
	public function sort ($f) {
		usort($this->arr, $f);
	}

	/**
	 * Removes `len` elements from `this` Array, starting at and including
	 * `pos`, an returns them.
	 * This operation modifies `this` Array in place.
	 * If `len` is < 0 or `pos` exceeds `this`.length, an empty Array [] is
	 * returned and `this` Array is unchanged.
	 * If `pos` is negative, its value is calculated from the end	of `this`
	 * Array by `this.length + pos`. If this yields a negative value, 0 is
	 * used instead.
	 * If the sum of the resulting values for `len` and `pos` exceed
	 * `this.length`, this operation will affect the elements from `pos` to the
	 * end of `this` Array.
	 * The length of the returned Array is equal to the new length of `this`
	 * Array subtracted from the original length of `this` Array. In other
	 * words, each element of the original `this` Array either remains in
	 * `this` Array or becomes an element of the returned Array.
	 * 
	 * @param int $pos
	 * @param int $len
	 * 
	 * @return Array_hx
	 */
	public function splice ($pos, $len) {
		if ($len < 0) {
			return new Array_hx();
		}
		$result = Array_hx::wrap(array_splice($this->arr, $pos, $len));
		$this->length -= $result->length;
		return $result;
	}

	/**
	 * Returns a string representation of `this` Array.
	 * The result will include the individual elements' String representations
	 * separated by comma. The enclosing [ ] may be missing on some platforms,
	 * use `Std.string()` to get a String representation that is consistent
	 * across platforms.
	 * 
	 * @return string
	 */
	public function toString () {
		$arr = $this->arr;
		$strings = [];
		foreach ($arr as $key => $value) {
			$strings[$key] = Boot::stringify($value, 9);
		}
		return "[" . (implode(",", $strings)??'null') . "]";
	}

	/**
	 * Adds the element `x` at the start of `this` Array.
	 * This operation modifies `this` Array in place.
	 * `this.length` and the index of each Array element increases by 1.
	 * 
	 * @param mixed $x
	 * 
	 * @return void
	 */
	public function unshift ($x) {
		$this->length = array_unshift($this->arr, $x);
	}

	public function __toString() {
		return $this->toString();
	}
}

Boot::registerClass(Array_hx::class, 'Array');
