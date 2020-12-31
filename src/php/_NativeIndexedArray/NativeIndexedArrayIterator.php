<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace php\_NativeIndexedArray;

use \php\Boot;

class NativeIndexedArrayIterator {
	/**
	 * @var int
	 */
	public $current;
	/**
	 * @var mixed
	 */
	public $data;
	/**
	 * @var int
	 */
	public $length;

	/**
	 * @param mixed $data
	 * 
	 * @return void
	 */
	public function __construct ($data) {
		$this->current = 0;
		$this->length = \count($data);
		$this->data = $data;
	}

	/**
	 * @return bool
	 */
	public function hasNext () {
		return $this->current < $this->length;
	}

	/**
	 * @return mixed
	 */
	public function next () {
		return $this->data[$this->current++];
	}
}

Boot::registerClass(NativeIndexedArrayIterator::class, 'php._NativeIndexedArray.NativeIndexedArrayIterator');
