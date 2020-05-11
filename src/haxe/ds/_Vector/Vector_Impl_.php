<?php
/**
 * Generated by Haxe 4.0.5
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
		$this1 = new PhpVectorData($length);
		return $this1;
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
				$_g1 = $len;
				while ($_g < $_g1) {
					$k = $_g++;
					--$i;
					--$j;
					$val = ($src->data[$i] ?? null);
					$src->data[$j] = $val;

				}

			} else if ($srcPos > $destPos) {
				$i1 = $srcPos;
				$j1 = $destPos;
				$_g2 = 0;
				$_g11 = $len;
				while ($_g2 < $_g11) {
					$k1 = $_g2++;
					$val1 = ($src->data[$i1] ?? null);
					$src->data[$j1] = $val1;

					++$i1;
					++$j1;
				}

			}
		} else {
			$_g3 = 0;
			$_g12 = $len;
			while ($_g3 < $_g12) {
				$i2 = $_g3++;
				$val2 = ($src->data[$srcPos + $i2] ?? null);
				$dest->data[$destPos + $i2] = $val2;

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
			$i = $_g++;
			$result = ($result . ($sep . \Std::string(($this1->data[$i] ?? null))));
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
		$this2 = new PhpVectorData($this1->length);
		$result = $this2;
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
		usort($this1->data, $f);
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
			$i = $_g++;
			$val = ($this1->data[$i] ?? null);
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
