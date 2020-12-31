<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace haxe\ds\_Vector;

use \php\Boot;

final class Vector_Impl_ {

	/**
	 * @param int $length
	 * 
	 * @return PhpVectorData
	 */
	public static function _new ($length) {
		return new PhpVectorData($length);
	}

	/**
	 * @param PhpVectorData $src
	 * @param int $srcPos
	 * @param PhpVectorData $dest
	 * @param int $destPos
	 * @param int $len
	 * 
	 * @return void
	 */
	public static function blit ($src, $srcPos, $dest, $destPos, $len) {
		if ($src === $dest) {
			if ($srcPos < $destPos) {
				$i = $srcPos + $len;
				$j = $destPos + $len;
				$_g = 0;
				while ($_g < $len) {
					++$_g;
					--$i;
					--$j;
					$val = ($src->data[$i] ?? null);
					$src->data[$j] = $val;
				}
			} else if ($srcPos > $destPos) {
				$i = $srcPos;
				$j = $destPos;
				$_g = 0;
				while ($_g < $len) {
					++$_g;
					$val = ($src->data[$i] ?? null);
					$src->data[$j] = $val;
					++$i;
					++$j;
				}
			}
		} else {
			$_g = 0;
			while ($_g < $len) {
				$i = $_g++;
				$val = ($src->data[$srcPos + $i] ?? null);
				$dest->data[$destPos + $i] = $val;
			}
		}
	}

	/**
	 * @param PhpVectorData $this
	 * 
	 * @return PhpVectorData
	 */
	public static function copy ($this1) {
		return (clone $this1);
	}

	/**
	 * @param \Array_hx $array
	 * 
	 * @return PhpVectorData
	 */
	public static function fromArrayCopy ($array) {
		$vectorData = new PhpVectorData($array->length);
		$vectorData->data = $array->arr;
		return $vectorData;
	}

	/**
	 * @param PhpVectorData $data
	 * 
	 * @return PhpVectorData
	 */
	public static function fromData ($data) {
		return $data;
	}

	/**
	 * @param PhpVectorData $this
	 * @param int $index
	 * 
	 * @return mixed
	 */
	public static function get ($this1, $index) {
		return ($this1->data[$index] ?? null);
	}

	/**
	 * @param PhpVectorData $this
	 * 
	 * @return int
	 */
	public static function get_length ($this1) {
		return $this1->length;
	}

	/**
	 * @param PhpVectorData $this
	 * @param string $sep
	 * 
	 * @return string
	 */
	public static function join ($this1, $sep) {
		if ($this1->length === 0) {
			return "";
		}
		$result = \Std::string(($this1->data[0] ?? null));
		$_g = 1;
		$_g1 = $this1->length;
		while ($_g < $_g1) {
			$result = ($result . ($sep . \Std::string(($this1->data[$_g++] ?? null))));
		}
		return $result;
	}

	/**
	 * @param PhpVectorData $this
	 * @param \Closure $f
	 * 
	 * @return PhpVectorData
	 */
	public static function map ($this1, $f) {
		$result = new PhpVectorData($this1->length);
		$collection = $this1->data;
		foreach ($collection as $key => $value) {
			$val = $f($value);
			$result->data[$key] = $val;
		}
		return $result;
	}

	/**
	 * @param PhpVectorData $this
	 * @param int $index
	 * @param mixed $val
	 * 
	 * @return mixed
	 */
	public static function set ($this1, $index, $val) {
		return $this1->data[$index] = $val;
	}

	/**
	 * @param PhpVectorData $this
	 * @param \Closure $f
	 * 
	 * @return void
	 */
	public static function sort ($this1, $f) {
		\usort($this1->data, $f);
	}

	/**
	 * @param PhpVectorData $this
	 * 
	 * @return \Array_hx
	 */
	public static function toArray ($this1) {
		$result = new \Array_hx();
		$result->length = $this1->length;
		$_g = 0;
		$_g1 = $this1->length;
		while ($_g < $_g1) {
			$val = ($this1->data[$_g++] ?? null);
			$result->arr[] = $val;
		}
		return $result;
	}

	/**
	 * @param PhpVectorData $this
	 * 
	 * @return PhpVectorData
	 */
	public static function toData ($this1) {
		return $this1;
	}
}

Boot::registerClass(Vector_Impl_::class, 'haxe.ds._Vector.Vector_Impl_');
Boot::registerGetters('haxe\\ds\\_Vector\\Vector_Impl_', [
	'length' => true
]);
