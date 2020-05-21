<?php
/**
 * Generated by Haxe 4.1.0
 */

namespace haxe\iterators;

use \php\Boot;

/**
 * This iterator is used only when `Array<T>` is passed to `Iterable<T>`
 */
class ArrayIterator {
	/**
	 * @var \Array_hx
	 */
	public $array;
	/**
	 * @var int
	 */
	public $current;

	/**
	 * Create a new `ArrayIterator`.
	 * 
	 * @param \Array_hx $array
	 * 
	 * @return void
	 */
	public function __construct ($array) {
		$this->current = 0;
		$this->array = $array;
	}

	/**
	 * See `Iterator.hasNext`
	 * 
	 * @return bool
	 */
	public function hasNext () {
		return $this->current < $this->array->length;
	}

	/**
	 * See `Iterator.next`
	 * 
	 * @return mixed
	 */
	public function next () {
		return ($this->array->arr[$this->current++] ?? null);
	}
}

Boot::registerClass(ArrayIterator::class, 'haxe.iterators.ArrayIterator');
