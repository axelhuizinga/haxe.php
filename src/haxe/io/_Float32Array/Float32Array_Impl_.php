<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace haxe\io\_Float32Array;

use \php\Boot;
use \haxe\Exception;
use \haxe\io\Error;
use \haxe\io\_ArrayBufferView\ArrayBufferView_Impl_;
use \haxe\io\Bytes;
use \haxe\io\ArrayBufferViewImpl;

final class Float32Array_Impl_ {
	/**
	 * @var int
	 */
	const BYTES_PER_ELEMENT = 4;


	/**
	 * @param int $elements
	 * 
	 * @return ArrayBufferViewImpl
	 */
	public static function _new ($elements) {
		$size = $elements * 4;
		return new ArrayBufferViewImpl(Bytes::alloc($size), 0, $size);
	}

	/**
	 * @param \Array_hx $a
	 * @param int $pos
	 * @param int $length
	 * 
	 * @return ArrayBufferViewImpl
	 */
	public static function fromArray ($a, $pos = 0, $length = null) {
		if ($pos === null) {
			$pos = 0;
		}
		if ($length === null) {
			$length = $a->length - $pos;
		}
		if (($pos < 0) || ($length < 0) || (($pos + $length) > $a->length)) {
			throw Exception::thrown(Error::OutsideBounds());
		}
		$size = $a->length * 4;
		$i = new ArrayBufferViewImpl(Bytes::alloc($size), 0, $size);
		$_g = 0;
		$_g1 = $length;
		while ($_g < $_g1) {
			$idx = $_g++;
			if (($idx >= 0) && ($idx < ($i->byteLength >> 2))) {
				$i->bytes->setFloat(($idx << 2) + $i->byteOffset, ($a->arr[$idx + $pos] ?? null));
			}
		}
		return $i;
	}

	/**
	 * @param Bytes $bytes
	 * @param int $bytePos
	 * @param int $length
	 * 
	 * @return ArrayBufferViewImpl
	 */
	public static function fromBytes ($bytes, $bytePos = 0, $length = null) {
		if ($bytePos === null) {
			$bytePos = 0;
		}
		return Float32Array_Impl_::fromData(ArrayBufferView_Impl_::fromBytes($bytes, $bytePos, (($length === null ? ($bytes->length - $bytePos) >> 2 : $length)) << 2));
	}

	/**
	 * @param ArrayBufferViewImpl $d
	 * 
	 * @return ArrayBufferViewImpl
	 */
	public static function fromData ($d) {
		return $d;
	}

	/**
	 * @param ArrayBufferViewImpl $this
	 * @param int $index
	 * 
	 * @return float
	 */
	public static function get ($this1, $index) {
		return $this1->bytes->getFloat(($index << 2) + $this1->byteOffset);
	}

	/**
	 * @param ArrayBufferViewImpl $this
	 * 
	 * @return ArrayBufferViewImpl
	 */
	public static function getData ($this1) {
		return $this1;
	}

	/**
	 * @param ArrayBufferViewImpl $this
	 * 
	 * @return int
	 */
	public static function get_length ($this1) {
		return $this1->byteLength >> 2;
	}

	/**
	 * @param ArrayBufferViewImpl $this
	 * 
	 * @return ArrayBufferViewImpl
	 */
	public static function get_view ($this1) {
		return $this1;
	}

	/**
	 * @param ArrayBufferViewImpl $this
	 * @param int $index
	 * @param float $value
	 * 
	 * @return float
	 */
	public static function set ($this1, $index, $value) {
		if (($index >= 0) && ($index < ($this1->byteLength >> 2))) {
			$this1->bytes->setFloat(($index << 2) + $this1->byteOffset, $value);
			return $value;
		}
		return 0;
	}

	/**
	 * @param ArrayBufferViewImpl $this
	 * @param int $begin
	 * @param int $length
	 * 
	 * @return ArrayBufferViewImpl
	 */
	public static function sub ($this1, $begin, $length = null) {
		return Float32Array_Impl_::fromData($this1->sub($begin << 2, ($length === null ? null : $length << 2)));
	}

	/**
	 * @param ArrayBufferViewImpl $this
	 * @param int $begin
	 * @param int $end
	 * 
	 * @return ArrayBufferViewImpl
	 */
	public static function subarray ($this1, $begin = null, $end = null) {
		return Float32Array_Impl_::fromData($this1->subarray(($begin === null ? null : $begin << 2), ($end === null ? null : $end << 2)));
	}
}

Boot::registerClass(Float32Array_Impl_::class, 'haxe.io._Float32Array.Float32Array_Impl_');
Boot::registerGetters('haxe\\io\\_Float32Array\\Float32Array_Impl_', [
	'view' => true,
	'length' => true
]);
